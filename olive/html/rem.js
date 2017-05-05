/*
 * @Author: chenliexin
 * @Date:   2016-07-25 22:49:08
 * @Last Modified by:   chenliexin
 * @Last Modified time: 2016-07-27 22:05:13
 */

'use strict';
// common: rem resize
(function(doc, win) {
    var docEl = doc.documentElement;
    var resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
        recalc = function() {
            var clientWidth = docEl.clientWidth;
            if (!clientWidth) {
                return;
            };
            docEl.style.fontSize = 100 * (Math.min(Math.max(clientWidth, 320), 750) / 375) + 'px';
            var docBd = doc.getElementsByTagName('body')[0];
        };
    if (!doc.addEventListener) {
        return;
    };
    win.addEventListener(resizeEvt, recalc, false);
    doc.addEventListener('DOMContentLoaded', recalc, false);
})(document, window);