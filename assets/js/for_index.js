function swipeDetect(e, t) {
    var a,
        r,
        n,
        o,
        i,
        d,
        c = e,
        s = t || function (e) {};
    c.addEventListener(
        "touchstart",
        function (e) {
            var t = e.changedTouches[0];
            (a = "none"),
                (dist = 0),
                (r = t.pageX),
                (n = t.pageY),
                (d = new Date().getTime());
        },
        !1
    ),
        c.addEventListener("touchmove", function (e) {}, !1),
        c.addEventListener(
            "touchend",
            function (e) {
                var t = e.changedTouches[0];
                (o = t.pageX - r),
                    (i = t.pageY - n),
                new Date().getTime() - d <= 300 &&
                (Math.abs(o) >= 150 && Math.abs(i) <= 100
                    ? (a = o < 0 ? "left" : "right")
                    : Math.abs(i) >= 150 &&
                    Math.abs(o) <= 100 &&
                    (a = i < 0 ? "up" : "down")),
                    s(a);
            },
            !1
        );
}
window.innerWidth < 768 &&
[].slice
    .call(document.querySelectorAll("[data-bss-disabled-mobile]"))
    .forEach(function (e) {
        e.classList.remove("animated"),
            e.removeAttribute("data-bss-hover-animate"),
            e.removeAttribute("data-aos"),
            e.removeAttribute("data-bss-parallax-bg"),
            e.removeAttribute("data-bss-scroll-zoom");
    }),
    document.addEventListener("DOMContentLoaded", function () {}, !1);
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
                let t = e.parent();
                (t.hasClass("drawer-push") || t.hasClass("drawer-slide")) &&
                t.addClass("open"),
                    $("body").addClass("drawer-open");
            }
            e.addClass("open").attr("data-open-drawer", "1");
        }
    },
    closeDrawer = function (e, t) {
        void 0 === t &&
        0 === (t = $(".navbar.fixed-top.off-canvas.open")).length &&
        (t = $('.navbar.fixed-top.off-canvas[data-open-drawer="1"]'));
        let a = t.parent();
        t.removeClass("open"),
            t.attr("data-open-drawer", "0"),
        anyOpenDrawers() ||
        ((a.hasClass("drawer-push") || a.hasClass("drawer-slide")) &&
        a.removeClass("open"),
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
        let t = null;
        return (
            e.each(function () {
                if (
                    void 0 === e.attr("data-right-drawer") ||
                    "0" == e.attr("data-right-drawer")
                )
                    return (t = e), !1;
            }),
                t
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
        let t = getLeftDrawer(),
            a = getRightDrawer();
        "left" === e
            ? t.length > 0 && isOpen(t)
                ? closeDrawer(t)
                : a.length > 0 && openDrawer(a)
            : "right" === e &&
            (a.length > 0 && isOpen(a)
                ? closeDrawer(a)
                : t.length > 0 && openDrawer(t));
    });
