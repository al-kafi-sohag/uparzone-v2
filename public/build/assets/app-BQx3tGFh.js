/**
 * @license lucide v0.503.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const f={xmlns:"http://www.w3.org/2000/svg",width:24,height:24,viewBox:"0 0 24 24",fill:"none",stroke:"currentColor","stroke-width":2,"stroke-linecap":"round","stroke-linejoin":"round"};/**
 * @license lucide v0.503.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const m=([e,n,t])=>{const r=document.createElementNS("http://www.w3.org/2000/svg",e);return Object.keys(n).forEach(o=>{r.setAttribute(o,String(n[o]))}),t!=null&&t.length&&t.forEach(o=>{const c=m(o);r.appendChild(c)}),r},p=(e,n={})=>{const t="svg",r={...f,...n};return m([t,r,e])};/**
 * @license lucide v0.503.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const g=e=>Array.from(e.attributes).reduce((n,t)=>(n[t.name]=t.value,n),{}),h=e=>typeof e=="string"?e:!e||!e.class?"":e.class&&typeof e.class=="string"?e.class.split(" "):e.class&&Array.isArray(e.class)?e.class:"",y=e=>e.flatMap(h).map(t=>t.trim()).filter(Boolean).filter((t,r,o)=>o.indexOf(t)===r).join(" "),b=e=>e.replace(/(\w)(\w*)(_|-|\s*)/g,(n,t,r)=>t.toUpperCase()+r.toLowerCase()),d=(e,{nameAttr:n,icons:t,attrs:r})=>{var u;const o=e.getAttribute(n);if(o==null)return;const c=b(o),s=t[c];if(!s)return console.warn(`${e.outerHTML} icon name was not found in the provided icons object.`);const a=g(e),i={...f,"data-lucide":o,...r,...a},l=y(["lucide",`lucide-${o}`,a,r]);l&&Object.assign(i,{class:l});const w=p(s,i);return(u=e.parentNode)==null?void 0:u.replaceChild(w,e)};/**
 * @license lucide v0.503.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const A=({icons:e={},nameAttr:n="data-lucide",attrs:t={}}={})=>{if(!Object.values(e).length)throw new Error(`Please provide an icons object.
If you want to use all the icons you can import it like:
 \`import { createIcons, icons } from 'lucide';
lucide.createIcons({icons});\``);if(typeof document>"u")throw new Error("`createIcons()` only works in a browser environment.");const r=document.querySelectorAll(`[${n}]`);if(Array.from(r).forEach(o=>d(o,{nameAttr:n,icons:e,attrs:t})),n==="data-lucide"){const o=document.querySelectorAll("[icon-name]");o.length>0&&(console.warn("[Lucide] Some icons were found with the now deprecated icon-name attribute. These will still be replaced for backwards compatibility, but will no longer be supported in v1.0 and you should switch to data-lucide"),Array.from(o).forEach(c=>d(c,{nameAttr:"icon-name",icons:e,attrs:t})))}};document.addEventListener("DOMContentLoaded",function(){A()});
