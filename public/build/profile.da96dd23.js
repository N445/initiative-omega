"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[845],{1620:(t,e,n)=>{n(9826),n(1539),n(2222),n(1058),n(4916),n(5306),n(9554),n(4747),n(686);var a=n(9755),i=void 0,c=function(t){a(t).find(".btn-remove-fleet").on("click",(function(e){e.preventDefault(),t.remove()}))};function l(t){return t.id?a('<span>\n            <img src="'.concat(a(t.element).attr("data-ship-banner"),'" class="img-fluid select2-ship-image d-block mx-auto" width="150" loading="lazy"/>\n            ').concat(t.text,"\n        </span>")):t.text}var r=function(t){a(t).find("select").select2({theme:"bootstrap-5",width:a(i).data("width")?a(i).data("width"):a(i).hasClass("w-100")?"100%":"style",placeholder:a(i).data("placeholder"),templateResult:l}).on("change",(function(e){a(t).find(".card-img-top").attr("src",a(t).find('select option[value="'.concat(a(this).val(),'"]')).attr("data-ship-banner"))}))},o=function(t){a(t).find(".add-quantity").on("click",(function(){var e=a(t).find(".number-ships input"),n=parseInt(e.val());e.val(n+1).change()})),a(t).find(".remove-quantity").on("click",(function(){var e=a(t).find(".number-ships input"),n=parseInt(e.val());n>e.attr("min")&&e.val(n-1).change()}))},d=function(t){var e=document.querySelector("."+t.currentTarget.dataset.collectionHolderClass),n=document.createElement("div");n.innerHTML=e.dataset.prototype.replace(/__name__/g,e.dataset.index),e.appendChild(n),e.dataset.index++,c(n),r(n),o(n)};document.querySelectorAll(".add_item_link").forEach((function(t){t.addEventListener("click",d)})),document.querySelectorAll(".fleets-form .fleet").forEach((function(t){c(t),r(t),o(t)}))}},t=>{t.O(0,[755,31,984,222],(()=>{return e=1620,t(t.s=e);var e}));t.O()}]);