// Avoid `console` errors in browsers that lack a console.
(function(){var e;var t=function(){};var n=["assert","clear","count","debug","dir","dirxml","error","exception","group","groupCollapsed","groupEnd","info","log","markTimeline","profile","profileEnd","table","time","timeEnd","timeStamp","trace","warn"];var r=n.length;var i=window.console=window.console||{};while(r--){e=n[r];if(!i[e]){i[e]=t}}})();

var body = document.body,
    timer;

var classList = false;
if (document.documentElement.classList) {
    classList = true;
}

var isMobile = body.classList.contains('is-mobile');

window.onload = function() {

    if(!body.classList.contains('is-desktop')) {
        hideAddressBar();
    }

    var header = document.getElementById('header');
    var navigation = document.getElementById('navigation');

    if (navigation) {

        var navigation_links = navigation.getElementsByClassName('js-navigation_link');

        if (navigation_links.length > 0) {
            for (var i = 0; i < navigation_links.length; i++) {

                var hrefValue = navigation_links[i].getAttribute('href');
                navigation_links[i].setAttribute('data-href', hrefValue);
                navigation_links[i].removeAttribute('href');

                navigation_links[i].addEventListener("click", function (event) {

                    smoothScroll.animateScroll(null, this.getAttribute('data-href'), { speed: 700, easing: 'easeOutCubic', offset: 70 });

                    for (var n = 0; n < navigation_links.length; n++) {
                        navigation_links[n].classList.remove("is-active");
                    }
                    this.classList.add("is-active");

                }, false);
            }
        }
    }

};

function hideAddressBar() {

    if (navigator.userAgent.indexOf('iPhone') != -1 || navigator.userAgent.indexOf('Android') != -1) {

        if (window.location.hash.indexOf('#') == -1) {
            addEventListener("load", function () {
                window.scrollTo(0, 1);
            }, false);
        }
    }
}

var testimonialList = document.getElementsByClassName('js-testimonial');
var counter = 1;

function testimonials()  {

    var timer = setInterval(function () {

        for (var i = 0; i < testimonialList.length; i++) {
            testimonialList[i].classList.remove("is-active");
            testimonialList[i].classList.remove("anm-testimonials");
        }

        testimonialList[counter].classList.add("is-active");
        testimonialList[counter].classList.add("anm-testimonials");
        counter++;

        if (counter > testimonialList.length - 1) {
            counter = 0;
        }

    }, 12500);
}

if (classList && testimonialList.length > 1) {
    testimonialList[0].classList.add("is-active");
    testimonialList[0].classList.add("anm-testimonials");
    testimonials();
}

var heroImageList = document.getElementsByClassName('js-heroImage');
var heroBulletsList = document.getElementsByClassName('js-heroBullet');
var heroContentList = document.getElementsByClassName('js-heroContent');
var counterImages = 1;

if (heroBulletsList.length > 0) {
    for (var i = 0; i < heroBulletsList.length; i++) {

        (function(protectedIndex){
            heroBulletsList[i].onclick= function() {

                for (var n = 0; n < heroBulletsList.length; n++) {
                    heroBulletsList[n].classList.remove("is-active");
                }
                this.classList.add("is-active");
                counterImages = protectedIndex;
                heroImages(true);
            }
        })(i);
    }
}

if (classList && heroImageList.length > 1) {
    heroImageList[0].classList.add("is-active");
    heroBulletsList[0].classList.add("is-active");
    heroContentList[0].classList.add("is-active");

    var timer = setInterval(function () {

        heroImages();

    }, 10500);
}

function heroImages(force)  {

    if (!force) {

            for (var i = 0; i < heroImageList.length; i++) {
                heroImageList[i].classList.remove("is-active");
                heroBulletsList[i].classList.remove("is-active");
                heroContentList[i].classList.remove("is-active");
            }

            heroImageList[counterImages].classList.add("is-active");
            heroBulletsList[counterImages].classList.add("is-active");
            heroContentList[counterImages].classList.add("is-active");
            counterImages++;

            //console.log('counterImages', counterImages);

            if (counterImages == heroImageList.length) {
                counterImages = 0;
            }

    } else {
        clearInterval(timer);
        heroImages();
    }
}

// Set the name of the hidden property and the change event for visibility
var hidden, visibilityChange;

if (typeof document.hidden !== "undefined") { // Opera 12.10 and Firefox 18 and later support
    hidden = "hidden";
    visibilityChange = "visibilitychange";
} else if (typeof document.mozHidden !== "undefined") {
    hidden = "mozHidden";
    visibilityChange = "mozvisibilitychange";
} else if (typeof document.msHidden !== "undefined") {
    hidden = "msHidden";
    visibilityChange = "msvisibilitychange";
} else if (typeof document.webkitHidden !== "undefined") {
    hidden = "webkitHidden";
    visibilityChange = "webkitvisibilitychange";
}

var initAnimationWindow = function() {
    if (! document[hidden]) {
        body.classList.add("window-active");
    }
};

document.addEventListener(visibilityChange, initAnimationWindow, false);

var handler = onVisibilityChange();

var handler_all = function() {
    handler();
    initAnimationWindow();
};

if (window.addEventListener) {
    addEventListener('load', handler_all, false);
} else if (window.attachEvent)  {
    attachEvent('onload', handler_all);
}

function isElementInViewport(el) {

    var rect = el.getBoundingClientRect();
    //console.log('rect', rect);
    //console.log('window.innerHeight', window.innerHeight);

    return (
    rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
    rect.left >= 0 &&
    rect.bottom >= 0 && /*or $(window).height() */
    rect.right <= (window.innerWidth || document.documentElement.clientWidth) /*or $(window).width() */
    );
}

var timerVisibility;
var elementsAnm = document.getElementsByClassName('js-anm');

for(var i = 0, length = elementsAnm.length; i < length; i++) {
    elementsAnm[i].classList.add("anm-ready");
}

function onVisibilityChange (el, callback) {
    return function () {

        var body = document.getElementById('body');
        var top = (body.pageYOffset || body.scrollTop) - (body.clientTop || 0);

        if (top > (window.innerHeight / 4)) {
            document.getElementById('header').classList.add("anm-active");
        } else {
            document.getElementById('header').classList.remove("anm-active");
        }

        if(!isMobile) {
            clearTimeout(timerVisibility);

            timerVisibility = setTimeout(function() {
                for(var i = 0, length = elementsAnm.length; i < length; i++) {
                    if (isElementInViewport(elementsAnm[i])) {
                        elementsAnm[i].classList.add("anm-active");
                    }
                }
            }, 50);
        }
    }
}

if (window.addEventListener) {
    addEventListener('DOMContentLoaded', handler_all, false);
    addEventListener('load', handler_all, false);
    addEventListener('scroll', handler, true);
    addEventListener('resize', handler_all, false);
} else if (window.attachEvent)  {
    attachEvent('onDOMContentLoaded', handler_all); // IE9+ :(
    attachEvent('onload', handler_all);
    attachEvent('onscroll', handler);
    attachEvent('onresize', handler_all);
}

function equalizeContainers(containerClass, targetClass) {
    var containerElements = document.getElementsByClassName(containerClass);

    for(var i = 0; i < containerElements.length; i++) {
        var highestElement = 0;
        var targetElements = containerElements[i].getElementsByClassName(targetClass);

        for(var j = 0; j < targetElements.length; j++) {
            var currentTargetElement = targetElements[j];
            currentTargetElement.style.height = "auto";
            var currentElementHeight = currentTargetElement.offsetHeight;

            if(currentElementHeight > highestElement) {
                highestElement = currentElementHeight;
            }
        }

        for(var j = 0; j < targetElements.length; j++) {
            targetElements[j].style.height = highestElement + "px";
        }
    }
}

if (window.innerWidth > 1023) {
    window.onload = equalizeContainers('js-equalize-container', 'js-equalize-target');
    window.onresize = equalizeContainers('js-equalize-container', 'js-equalize-target');
}

/*! smooth-scroll v5.3.3 | (c) 2014 Chris Ferdinandi | https://github.com/cferdinandi/smooth-scroll */
(function(e,t){if(typeof define==="function"&&define.amd){define("smoothScroll",t(e))}else if(typeof exports==="object"){module.exports=t(e)}else{e.smoothScroll=t(e)}})(window||this,function(e){"use strict";var t={};var n=!!document.querySelector&&!!e.addEventListener;var r,i,s;var o={speed:500,easing:"easeInOutCubic",offset:0,updateURL:true,callbackBefore:function(){},callbackAfter:function(){}};var u=function(e,t,n){if(Object.prototype.toString.call(e)==="[object Object]"){for(var r in e){if(Object.prototype.hasOwnProperty.call(e,r)){t.call(n,e[r],r,e)}}}else{for(var i=0,s=e.length;i<s;i++){t.call(n,e[i],i,e)}}};var a=function(e,t){var n={};u(e,function(t,r){n[r]=e[r]});u(t,function(e,r){n[r]=t[r]});return n};var f=function(e,t){var n=t.charAt(0);for(;e&&e!==document;e=e.parentNode){if(n==="."){if(e.classList.contains(t.substr(1))){return e}}else if(n==="#"){if(e.id===t.substr(1)){return e}}else if(n==="["){if(e.hasAttribute(t.substr(1,t.length-2))){return e}}}return false};var l=function(e){return Math.max(e.scrollHeight,e.offsetHeight,e.clientHeight)};var c=function(e){var t=String(e);var n=t.length;var r=-1;var i;var s="";var o=t.charCodeAt(0);while(++r<n){i=t.charCodeAt(r);if(i===0){throw new InvalidCharacterError("Invalid character: the input contains U+0000.")}if(i>=1&&i<=31||i==127||r===0&&i>=48&&i<=57||r===1&&i>=48&&i<=57&&o===45){s+="\\"+i.toString(16)+" ";continue}if(i>=128||i===45||i===95||i>=48&&i<=57||i>=65&&i<=90||i>=97&&i<=122){s+=t.charAt(r);continue}s+="\\"+t.charAt(r)}return s};var h=function(e,t){var n;if(e==="easeInQuad")n=t*t;if(e==="easeOutQuad")n=t*(2-t);if(e==="easeInOutQuad")n=t<.5?2*t*t:-1+(4-2*t)*t;if(e==="easeInCubic")n=t*t*t;if(e==="easeOutCubic")n=--t*t*t+1;if(e==="easeInOutCubic")n=t<.5?4*t*t*t:(t-1)*(2*t-2)*(2*t-2)+1;if(e==="easeInQuart")n=t*t*t*t;if(e==="easeOutQuart")n=1- --t*t*t*t;if(e==="easeInOutQuart")n=t<.5?8*t*t*t*t:1-8*--t*t*t*t;if(e==="easeInQuint")n=t*t*t*t*t;if(e==="easeOutQuint")n=1+ --t*t*t*t*t;if(e==="easeInOutQuint")n=t<.5?16*t*t*t*t*t:1+16*--t*t*t*t*t;return n||t};var p=function(e,t,n){var r=0;if(e.offsetParent){do{r+=e.offsetTop;e=e.offsetParent}while(e)}r=r-t-n;return r>=0?r:0};var d=function(){return Math.max(document.body.scrollHeight,document.documentElement.scrollHeight,document.body.offsetHeight,document.documentElement.offsetHeight,document.body.clientHeight,document.documentElement.clientHeight)};var v=function(e){return!e||!(typeof JSON==="object"&&typeof JSON.parse==="function")?{}:JSON.parse(e)};var m=function(t,n){if(history.pushState&&(n||n==="true")){history.pushState(null,null,[e.location.protocol,"//",e.location.host,e.location.pathname,e.location.search,t].join(""))}};t.animateScroll=function(t,n,r){var i=a(i||o,r||{});var u=v(t?t.getAttribute("data-options"):null);i=a(i,u);n="#"+c(n.substr(1));var f=n==="#"?document.documentElement:document.querySelector(n);var g=e.pageYOffset;if(!s){s=document.querySelector("[data-scroll-header]")}var y=s===null?0:l(s)+s.offsetTop;var b=p(f,y,parseInt(i.offset,10));var w;var E=b-g;var S=d();var x=0;var T,N;m(n,i.updateURL);var C=function(r,s,o){var u=e.pageYOffset;if(r==s||u==s||e.innerHeight+u>=S){clearInterval(o);f.focus();i.callbackAfter(t,n)}};var k=function(){x+=16;T=x/parseInt(i.speed,10);T=T>1?1:T;N=g+E*h(i.easing,T);e.scrollTo(0,Math.floor(N));C(N,b,w)};var L=function(){i.callbackBefore(t,n);w=setInterval(k,16)};if(e.pageYOffset===0){e.scrollTo(0,0)}L()};var g=function(e){var n=f(e.target,"[data-scroll]");if(n&&n.tagName.toLowerCase()==="a"){e.preventDefault();t.animateScroll(n,n.hash,r)}};var y=function(e){if(!i){i=setTimeout(function(){i=null;headerHeight=s===null?0:l(s)+s.offsetTop},66)}};t.destroy=function(){if(!r)return;document.removeEventListener("click",g,false);e.removeEventListener("resize",y,false);r=null;i=null;s=null};t.init=function(i){if(!n)return;t.destroy();r=a(o,i||{});s=document.querySelector("[data-scroll-header]");document.addEventListener("click",g,false);if(s){e.addEventListener("resize",y,false)}};return t});

smoothScroll.init();