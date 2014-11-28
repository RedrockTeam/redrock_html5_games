function random(d, e) {
    var f = parseInt(Math.random() * e);
    var g = [];
    if (d == 0) {
        return g
    }
    do {
        var b = 1;
        do {
            for (var c = 0; c < g.length; c++) {
                if (g[c] == f) {
                    b = 0;
                    break
                }
            }
            if (b) {
                g[g.length] = f
            } else {
                f = parseInt(Math.random() * e)
            }
        } while (b)
    } while (g.length < d);
    return g
}
function testColl(c, s, l, o, b, q, h, n) {
    var g = c;
    var e = c + l;
    var m = s;
    var r = s + o;
    var f = b;
    var d = b + h;
    var i = q;
    var p = q + n;
    if (e - 15 < f || g + 15 > d || r < i || m > p - 15) {
        return false
    } else {
        return true
    }
}
function loadImgs(b, g) {
    var f = {};
    var d = 0;
    for (var e = 0; e < b.length; e++) {
        var h = new Image();
        h.src = "resource/run/images/" + b[e];
        var c = b[e].split(".")[0];
        h.onload = function () {
            d++;
            if (d == b.length) {
                if (g) {
                    g()
                }
            }
        };
        f[c] = h
    }
    return f
}
$(function () {
    var z = $("#canvas");
    var s = z[0].getContext("2d");
    var C = 0;
    var o = 0;
    var m = 0;
    var p = 6;
    var B = -2000;
    var e = $("#start");
    var r = $("#begin_web");
    var q = $("#tips_web");
    var f = $("#tips");
    var i = $("#tip_start");
    var b = $("#score_list");
    var w = $("#share");
    var g = $("#share_img");
    var l = 240;
    var h = 0;
    var A = $("#loading");
    var d = $("#time");
    var n = $("#reload");
    var u = $("#reply");
    var c = ["begin_bg.jpg", "share.jpg", "zhiyuanzhe.png", "runway.jpg", "chi.png", "jita.png", "jiuping.png", "person.png", "pingpang.png", "qianbi.png", "dao.png", "shu.png", "yantou.png", "shaizi.png", "zuqiu.png", "dabian.png"];
    if ($(window).width() >= 780) {
        document.body.innerHTML = ' ';
        alert("请在手机微信上使用!");
    }
    ;
    var t = loadImgs(c, function () {
        A.css("display", "none");
        r.css("display", "block")
    });
    u.click(function () {
        var v = phone_input.value;
        if (v.length != 11) {
            alert("请输入正确的手机号！");
            return
        }
        var x = a.getAttribute("data");
        $.ajax({
            url: "/game/public/post",
            type: "post",
            dataType: "json",
            contentType: "application/json",
            data: JSON.stringify({_token: x, score:C, phone: v, time: l, type: "run"})
        }).fail(function () {
            alert("与服务器连接错误!")
        }).complete(function (y) {
            y = y.responseJSON;
            var E = y.rank;
            alert("你的排名为第" + E + "名!赶快分享到朋友圈叫大家一起参与吧!");
            document.title = "我在奔跑吧兄弟中获得了" + C + "分,排名为第" + E + "名，快来一起参加吧！"
        })
    });
    document.title = "欢迎使用“四个一”素质提升活动游戏——奔跑吧兄弟";
    n.click(function () {
        self.location.reload()
    });
    n[0].addEventListener("click", function () {
        self.location.reload()
    });
    if ($(window).height() <= 470) {
        r.css("height", $(window).height());
        q.css("height", $(window).height());
        z[0].height = $(window).height();
        g.css("height", $(window).height());
        container.style.height = $(window).height() + "px";
        w.css("height", $(window).height())
    }
    e.click(function () {
        r.css("display", "none");
        b.css("display", "block");
        z.css("visibility", "visible");
        D(t)
    });
    f.click(function () {
        r.css("display", "none");
        q.css("display", "block")
    });
    i.click(function () {
        q.css("display", "none");
        b.css("display", "block");
        z.css("visibility", "visible");
        D(t)
    });
    function D(I) {
        setInterval(function () {
            if (B < -794) {
                z[0].style.backgroundPositionY = B + "px";
                B += 3
            } else {
                B = (-2000)
            }
        }, 1);
        var y = setInterval(function () {
            l--
        }, 1000);
        onkeydown = function (S) {
            var Q = S || event;
            var R = Q.keyCode;
            switch (R) {
                case 37:
                    if (o == 0) {
                        return
                    }
                    o--;
                    break;
                case 39:
                    if (o == 3) {
                        return
                    }
                    o++;
                    break
            }
        };
        function N() {
            if (h == 12 && x < 4) {
                x++;
                h = 0
            }
            if (window.timer) {
                clearTimeout(timer)
            }
            if (h == 10 && p < 10) {
                p += 1
            }
            window.timer = setTimeout(function () {
                if (l == 0) {
                    alert("时间到了，游戏结束.!");
                    z.css("display", "none");
                    w.css("display", "block");
                    b.css("display", "none");
                    return
                }
                s.clearRect(0, 0, z[0].width, z[0].height);
                d[0].innerHTML = " " + l + " ";
                for (var R = 0; R < M.length; R++) {
                    var Q = testColl(M[R].x, M[R].y, 50, 20, G, F, 82, 100);
                    if (Q) {
                        M.splice(R, 1);
                        h++;
                        C += 100;
                        ScoreNum.innerHTML = " " + C + " ";
                        continue
                    }
                    s.drawImage(I[M[R].name], M[R].x, M[R].y);
                    M[R].y += p;
                    if (M[R].y >= (z.height()) - 75) {
                        M.splice(R, 1);
                        continue
                    }
                }
                for (var R = 0; R < H.length; R++) {
                    var Q = testColl(H[R].x, H[R].y, 48, 5, G, F + 6, 63, 78);
                    if (Q) {
                        document.title = "我在奔跑吧兄弟中获得了" + C + "分，快来一起参加吧！";
                        setTimeout(function () {
                            z.css("display", "none");
                            w.css("display", "block");
                            b.css("display", "none")
                        }, 100);
                        H.splice(R, 1);
                        alert("你沾染了不文明物品，游戏结束！");
                        return
                    }
                    s.drawImage(I[H[R].name], H[R].x, H[R].y);
                    H[R].y += 8;
                    if (H[R].y >= (z.height() - 75)) {
                        H.splice(R, 1);
                        continue
                    }
                }
                s.drawImage(I["person"], 0, 110 * m, 62, 110, G, F, 62, 110);
                if (m == 0) {
                    m = 1
                } else {
                    m = 0
                }
                N()
            }, 30)
        }

        N();
        var M = [];
        var J = 3;
        var E = z[0].offsetWidth / parseInt(z[0].offsetWidth / 64);
        var O = ["chi", "jita", "pingpang", "shu", "zuqiu", "qianbi", "zhiyuanzhe"];

        function P() {
            var S = random(J, 4);
            var Q = random(J, 300);
            var R = random(J, 7);
            for (var T = 0; T < S.length; T++) {
                M.push({name: O[R[T]], x: S[T] * 90, y: -60 - Q[T]})
            }
        }

        setInterval(function () {
            P()
        }, 5000);
        var G = 120;
        var F = 340;
        z[0].addEventListener("touchstart", function (R) {
            var Q = R.touches[0] || event.touches[0];
            j = Q.clientX - G;
            k = Q.clientY - F;
            z[0].addEventListener("touchmove", function (U) {
                var T = U.changedTouches[0] || event.changedTouches[0];
                var S = T.clientX - j;
                var V = T.clientY - k;
                if (S < 0) {
                    G = 0
                } else {
                    if (S > 245) {
                        G = 245
                    } else {
                        G = S
                    }
                }
                if (V > 340) {
                    F = 340
                } else {
                    if (V < 0) {
                        F = 0
                    } else {
                        F = V
                    }
                }
                U.preventDefault()
            });
            R.preventDefault()
        });
        var H = [];
        var x = 1;
        var L = ["shaizi", "jiuping", "yantou", "dabian", "dao"];

        function K() {
            var S = random(x, 4);
            var R = random(x, 500);
            var Q = random(x, L.length);
            for (var T = 0; T < S.length; T++) {
                H.push({name: L[Q[T]], x: S[T] * 90, y: -60 - R[T]})
            }
        }

        function v() {
            setTimeout(function () {
                K();
                v()
            }, 3000)
        }

        v()
    }
});
function echo(d, c) {
    var b = "你好";
    alert("hello world")
};