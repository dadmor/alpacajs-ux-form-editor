!function(e,n){"function"==typeof define&&define.amd?define(["lodash"],n):"object"==typeof exports?module.exports=n(require("lodash").runInContext()):e._.mixin(n(e._))}(this,function(e){"use strict";function n(n){return e.isArray(n)?n:e.isString(n)?t(n):[]}function t(e){for(var n="",t=[],r="",d=!1,i=!1,p=!1,a=0;a<e.length;a++)if(n=e[a],i="\\"===n||"["===n||"]"===n||"."===n,i&&!d){if(p&&"]"!==n)throw new SyntaxError('unexpected "'+n+'" within brackets at character '+a+" in property path "+e);switch(n){case"\\":d=!0;break;case"]":p=!1;break;case"[":p=!0;case".":t.push(r),r=""}}else r+=n,d=!1;return""===t[0]&&t.splice(0,1),t.push(r),t}function r(n){return function(t,r){return n(t,function(n){return e.deepGet(n,r)})}}function d(e){var n=[];return n[e]=null,n.length>0}var i={deepIn:function(t,r){for(var d=n(r),i=0;i<d.length;i++){var p=d[i];if(!(e.has(t,p)||e.isObject(t)&&p in t))return!1;t=t[p]}return!0},deepHas:function(t,r){for(var d=n(r),i=0;i<d.length;i++){var p=d[i];if(!e.has(t,p))return!1;t=t[p]}return!0},deepOwn:function(t,r){var d=n(r);return e.deepHas(t,d)?e.reduce(d,function(e,n){return e[n]},t):void 0},deepGet:function(t,r){var d=n(r);return e.deepIn(t,d)?e.reduce(d,function(e,n){return e[n]},t):void 0},deepSet:function(t,r,i){var p=n(r),a=t;return e.forEach(p,function(n,t){t+1===p.length?a[n]=i:e.isObject(a[n])||(a[n]=d(p[t+1])?[]:{}),a=a[n]}),t},deepDefault:function(n,t,r){var d=e.deepGet(n,t);return e.isUndefined(d)?(e.deepSet(n,t,r),r):d},deepCall:function(n,t,r){var d=Array.prototype.slice.call(arguments,3);return e.deepApply(n,t,r,d)},deepApply:function(n,t,r,d){var i=e.deepGet(n,t);return e.isFunction(i)?i.apply(r,d):void 0},deepEscapePropertyName:function(e){return e.replace(/\\/g,"\\\\").replace(/(\.|\[|\])/g,"\\$1")},deepMapValues:function(t,r,d){function i(n,t){return e.deepMapValues(n,r,e.flatten([p,t]))}var p=n(d);return e.isArray(t)?e.map(t,i):!e.isObject(t)||e.isDate(t)||e.isRegExp(t)?r(t,p):e.extend({},t,e.mapValues(t,i))},deepPluck:r(e.map),deepFindIndex:r(e.findIndex),deepFindLastIndex:r(e.findLastIndex),deepFirst:r(e.first),deepFlatten:r(e.flatten),deepInitial:r(e.initial),deepLast:r(e.last),deepLastIndexOf:r(e.lastIndexOf),deepRemove:r(e.remove),deepRest:r(e.rest),deepSortedIndex:r(e.sortedIndex),deepUniq:r(e.uniq),deepCountBy:r(e.countBy),deepEvery:r(e.every),deepFilter:r(e.filter),deepFind:r(e.find),deepGroupBy:r(e.groupBy),deepIndexBy:r(e.indexBy),deepMax:r(e.max),deepMin:r(e.min),deepReject:r(e.reject),deepSome:r(e.some),deepSortBy:r(e.sortBy),deepFindKey:r(e.findKey),deepFindLastKey:r(e.findLastKey)};return i.deepSetValue=i.deepSet,i.deepGetValue=i.deepGet,i.deepGetOwnValue=i.deepOwn,e.mixin(i),i});