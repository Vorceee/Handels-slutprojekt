if(!self.define){let e,s={};const i=(i,n)=>(i=new URL(i+".js",n).href,s[i]||new Promise((s=>{if("document"in self){const e=document.createElement("script");e.src=i,e.onload=s,document.head.appendChild(e)}else e=i,importScripts(i),s()})).then((()=>{let e=s[i];if(!e)throw new Error(`Module ${i} didn’t register its module`);return e})));self.define=(n,a)=>{const t=e||("document"in self?document.currentScript.src:"")||location.href;if(s[t])return;let c={};const r=e=>i(e,t),o={module:{uri:t},exports:c,require:r};s[t]=Promise.all(n.map((e=>o[e]||r(e)))).then((e=>(a(...e),c)))}}define(["./workbox-5afaf374"],(function(e){"use strict";importScripts(),self.skipWaiting(),e.clientsClaim(),e.precacheAndRoute([{url:"/_next/static/W04riJDiPRqT0Uo54eEX0/_buildManifest.js",revision:"W04riJDiPRqT0Uo54eEX0"},{url:"/_next/static/W04riJDiPRqT0Uo54eEX0/_middlewareManifest.js",revision:"W04riJDiPRqT0Uo54eEX0"},{url:"/_next/static/W04riJDiPRqT0Uo54eEX0/_ssgManifest.js",revision:"W04riJDiPRqT0Uo54eEX0"},{url:"/_next/static/chunks/867-bbbb4a3a10198f89.js",revision:"W04riJDiPRqT0Uo54eEX0"},{url:"/_next/static/chunks/framework-fc97f3f1282ce3ed.js",revision:"W04riJDiPRqT0Uo54eEX0"},{url:"/_next/static/chunks/main-58544bb07492b0c4.js",revision:"W04riJDiPRqT0Uo54eEX0"},{url:"/_next/static/chunks/pages/_app-76df4f01d5543c55.js",revision:"W04riJDiPRqT0Uo54eEX0"},{url:"/_next/static/chunks/pages/_error-1995526792b513b2.js",revision:"W04riJDiPRqT0Uo54eEX0"},{url:"/_next/static/chunks/pages/about-6ea5038faeed75b2.js",revision:"W04riJDiPRqT0Uo54eEX0"},{url:"/_next/static/chunks/pages/company/%5Bid%5D-5a4a1472fff63e2d.js",revision:"W04riJDiPRqT0Uo54eEX0"},{url:"/_next/static/chunks/pages/competitions-ad94dddb6fe647a3.js",revision:"W04riJDiPRqT0Uo54eEX0"},{url:"/_next/static/chunks/pages/events-8d5c4ac056d37dd2.js",revision:"W04riJDiPRqT0Uo54eEX0"},{url:"/_next/static/chunks/pages/food-c1d35c3268c0c3d1.js",revision:"W04riJDiPRqT0Uo54eEX0"},{url:"/_next/static/chunks/pages/index-b22cd9f401a92e18.js",revision:"W04riJDiPRqT0Uo54eEX0"},{url:"/_next/static/chunks/pages/offers-0e806b4f6a5b9b0a.js",revision:"W04riJDiPRqT0Uo54eEX0"},{url:"/_next/static/chunks/polyfills-5cd94c89d3acac5f.js",revision:"W04riJDiPRqT0Uo54eEX0"},{url:"/_next/static/chunks/webpack-69bfa6990bb9e155.js",revision:"W04riJDiPRqT0Uo54eEX0"},{url:"/_next/static/css/2740b87ab57b99e9.css",revision:"W04riJDiPRqT0Uo54eEX0"},{url:"/android-chrome-192x192.png",revision:"59b5d68d44ab0b139dbf012d284ad218"},{url:"/android-chrome-512x512.png",revision:"92c6e5d5fd737ae133a5a86eb64d4f9e"},{url:"/apple-touch-icon.png",revision:"374996bcacc80bc7d5df86ff5b802116"},{url:"/favicon-16x16.png",revision:"1e38ae0ae6da736f44bb6c9c24b26950"},{url:"/favicon-32x32.png",revision:"8186e4b971027c1934d5b2cbd4f6fc15"},{url:"/favicon.ico",revision:"08985d818b9752520d656f868d90db63"},{url:"/files/lokal.png",revision:"39cd7f96726dbccc2bd44b09ace2e254"},{url:"/files/lokalhandels.PNG",revision:"025bbc4efd4fc6586979664eeefb05f4"},{url:"/files/programblad.pdf",revision:"7342c1231335312ae92f98657d087147"},{url:"/icon-192x192.png",revision:"b66fd85b934893a9482a7c3e7d304ca4"},{url:"/icon-256x256.png",revision:"624f0c22f329c6bc4b07bc183af782d4"},{url:"/icon-384x384.png",revision:"4a724c27d1a4e2a0564de7f8e275358e"},{url:"/icon-512x512.png",revision:"34e75bb0887a4a25f241aadca05e82cd"},{url:"/manifest.json",revision:"5cb6d71b2a0d815a70559bd291613289"},{url:"/site.webmanifest",revision:"053100cb84a50d2ae7f5492f7dd7f25e"},{url:"/vercel.svg",revision:"4b4f1876502eb6721764637fe5c41702"}],{ignoreURLParametersMatching:[]}),e.cleanupOutdatedCaches(),e.registerRoute("/",new e.NetworkFirst({cacheName:"start-url",plugins:[{cacheWillUpdate:async({request:e,response:s,event:i,state:n})=>s&&"opaqueredirect"===s.type?new Response(s.body,{status:200,statusText:"OK",headers:s.headers}):s}]}),"GET"),e.registerRoute(/^https:\/\/fonts\.(?:gstatic)\.com\/.*/i,new e.CacheFirst({cacheName:"google-fonts-webfonts",plugins:[new e.ExpirationPlugin({maxEntries:4,maxAgeSeconds:31536e3})]}),"GET"),e.registerRoute(/^https:\/\/fonts\.(?:googleapis)\.com\/.*/i,new e.StaleWhileRevalidate({cacheName:"google-fonts-stylesheets",plugins:[new e.ExpirationPlugin({maxEntries:4,maxAgeSeconds:604800})]}),"GET"),e.registerRoute(/\.(?:eot|otf|ttc|ttf|woff|woff2|font.css)$/i,new e.StaleWhileRevalidate({cacheName:"static-font-assets",plugins:[new e.ExpirationPlugin({maxEntries:4,maxAgeSeconds:604800})]}),"GET"),e.registerRoute(/\.(?:jpg|jpeg|gif|png|svg|ico|webp)$/i,new e.StaleWhileRevalidate({cacheName:"static-image-assets",plugins:[new e.ExpirationPlugin({maxEntries:64,maxAgeSeconds:86400})]}),"GET"),e.registerRoute(/\/_next\/image\?url=.+$/i,new e.StaleWhileRevalidate({cacheName:"next-image",plugins:[new e.ExpirationPlugin({maxEntries:64,maxAgeSeconds:86400})]}),"GET"),e.registerRoute(/\.(?:mp3|wav|ogg)$/i,new e.CacheFirst({cacheName:"static-audio-assets",plugins:[new e.RangeRequestsPlugin,new e.ExpirationPlugin({maxEntries:32,maxAgeSeconds:86400})]}),"GET"),e.registerRoute(/\.(?:mp4)$/i,new e.CacheFirst({cacheName:"static-video-assets",plugins:[new e.RangeRequestsPlugin,new e.ExpirationPlugin({maxEntries:32,maxAgeSeconds:86400})]}),"GET"),e.registerRoute(/\.(?:js)$/i,new e.StaleWhileRevalidate({cacheName:"static-js-assets",plugins:[new e.ExpirationPlugin({maxEntries:32,maxAgeSeconds:86400})]}),"GET"),e.registerRoute(/\.(?:css|less)$/i,new e.StaleWhileRevalidate({cacheName:"static-style-assets",plugins:[new e.ExpirationPlugin({maxEntries:32,maxAgeSeconds:86400})]}),"GET"),e.registerRoute(/\/_next\/data\/.+\/.+\.json$/i,new e.StaleWhileRevalidate({cacheName:"next-data",plugins:[new e.ExpirationPlugin({maxEntries:32,maxAgeSeconds:86400})]}),"GET"),e.registerRoute(/\.(?:json|xml|csv)$/i,new e.NetworkFirst({cacheName:"static-data-assets",plugins:[new e.ExpirationPlugin({maxEntries:32,maxAgeSeconds:86400})]}),"GET"),e.registerRoute((({url:e})=>{if(!(self.origin===e.origin))return!1;const s=e.pathname;return!s.startsWith("/api/auth/")&&!!s.startsWith("/api/")}),new e.NetworkFirst({cacheName:"apis",networkTimeoutSeconds:10,plugins:[new e.ExpirationPlugin({maxEntries:16,maxAgeSeconds:86400})]}),"GET"),e.registerRoute((({url:e})=>{if(!(self.origin===e.origin))return!1;return!e.pathname.startsWith("/api/")}),new e.NetworkFirst({cacheName:"others",networkTimeoutSeconds:10,plugins:[new e.ExpirationPlugin({maxEntries:32,maxAgeSeconds:86400})]}),"GET"),e.registerRoute((({url:e})=>!(self.origin===e.origin)),new e.NetworkFirst({cacheName:"cross-origin",networkTimeoutSeconds:10,plugins:[new e.ExpirationPlugin({maxEntries:32,maxAgeSeconds:3600})]}),"GET")}));
