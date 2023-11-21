function swipeDetect(e, a) {
    var t,
        r,
        n,
        o,
        c,
        i,
        d = e,
        s = a || function (e) {};
    d.addEventListener(
        "touchstart",
        function (e) {
            var a = e.changedTouches[0];
            (t = "none"),
                (dist = 0),
                (r = a.pageX),
                (n = a.pageY),
                (i = new Date().getTime());
        },
        !1
    ),
        d.addEventListener("touchmove", function (e) {}, !1),
        d.addEventListener(
            "touchend",
            function (e) {
                var a = e.changedTouches[0];
                (o = a.pageX - r),
                    (c = a.pageY - n),
                new Date().getTime() - i <= 300 &&
                (Math.abs(o) >= 150 && Math.abs(c) <= 100
                    ? (t = o < 0 ? "left" : "right")
                    : Math.abs(c) >= 150 &&
                    Math.abs(o) <= 100 &&
                    (t = c < 0 ? "up" : "down")),
                    s(t);
            },
            !1
        );
}
let isOpen = function (e) {
        return "1" == e.attr("data-open-drawer") || e.hasClass("open");
    },
    anyOpenDrawers = function () {
        let e = !1;
        return (
            $(".navbar.fixed-top.off-canvas").each(function () {
                if (isOpen($(this))) return (e = !0), !1;
            }),
                e
        );
    },
    openDrawer = function (e) {
        if (!isOpen(e)) {
            if (!anyOpenDrawers()) {
                let a = e.parent();
                (a.hasClass("drawer-push") || a.hasClass("drawer-slide")) &&
                a.addClass("open"),
                    $("body").addClass("drawer-open");
            }
            e.addClass("open").attr("data-open-drawer", "1");
        }
    },
    closeDrawer = function (e, a) {
        void 0 === a &&
        0 === (a = $(".navbar.fixed-top.off-canvas.open")).length &&
        (a = $('.navbar.fixed-top.off-canvas[data-open-drawer="1"]'));
        let t = a.parent();
        a.removeClass("open"),
            a.attr("data-open-drawer", "0"),
        anyOpenDrawers() ||
        ((t.hasClass("drawer-push") || t.hasClass("drawer-slide")) &&
        t.removeClass("open"),
            $("body").removeClass("drawer-open"));
    },
    getRightDrawer = function () {
        let e = $(".navbar.fixed-top.off-canvas.right-drawer");
        return (
            0 === e.length &&
            (e = $('.navbar.fixed-top.off-canvas[data-right-drawer="1"]')),
            0 === e.length && (e = null),
                e
        );
    },
    getLeftDrawer = function () {
        let e = $(".navbar.fixed-top.off-canvas:not(.right-drawer)");
        if (0 === e.length) return null;
        let a = null;
        return (
            e.each(function () {
                if (
                    void 0 === e.attr("data-right-drawer") ||
                    "0" == e.attr("data-right-drawer")
                )
                    return (a = e), !1;
            }),
                a
        );
    },
    toggleDrawer = function (e) {
        isOpen(e) ? closeDrawer(e) : openDrawer(e);
    };
$(document).on("click touch", '[data-dismiss="drawer"]', {}, closeDrawer),
    $(document).on(
        "click touch",
        '[data-dismiss="left-drawer"]',
        {},
        function (e) {
            closeDrawer(e, getLeftDrawer());
        }
    ),
    $(document).on(
        "click touch",
        '[data-dismiss="right-drawer"]',
        {},
        function (e) {
            closeDrawer(e, getRightDrawer());
        }
    ),
    $(document).on("click touch", '[data-open="drawer"]', {}, function () {
        openDrawer($(".navbar.fixed-top.off-canvas:not(.open)"));
    }),
    $(document).on("click touch", '[data-open="left-drawer"]', {}, function () {
        openDrawer(getLeftDrawer());
    }),
    $(document).on("click touch", '[data-open="right-drawer"]', {}, function () {
        openDrawer(getRightDrawer());
    }),
    $(document).on("click touch", '[data-toggle="drawer"]', {}, function () {
        toggleDrawer($(".navbar.fixed-top.off-canvas"));
    }),
    $(document).on("click touch", '[data-toggle="left-drawer"]', {}, function () {
        toggleDrawer(getLeftDrawer());
    }),
    $(document).on(
        "click touch",
        '[data-toggle="right-drawer"]',
        {},
        function () {
            toggleDrawer(getRightDrawer());
        }
    ),
    swipeDetect($(document)[0], function (e) {
        let a = getLeftDrawer(),
            t = getRightDrawer();
        "left" === e
            ? a.length > 0 && isOpen(a)
                ? closeDrawer(a)
                : t.length > 0 && openDrawer(t)
            : "right" === e &&
            (t.length > 0 && isOpen(t)
                ? closeDrawer(t)
                : a.length > 0 && openDrawer(a));
    });
