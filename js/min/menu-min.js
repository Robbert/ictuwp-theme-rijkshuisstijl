// * @license GPL-2.0+
var menu_open=menumenu.menu_open,menu_close=menumenu.menu_close,search_open=menumenu.search_open,search_close=menumenu.search_close,buttons_container=document.getElementById("buttons_container"),menu_container=document.getElementById("menu_container"),menu_button=document.getElementById("menu_button"),search_container=document.getElementById("search_container"),search_button=document.getElementById("search_button"),navsecondary=document.getElementsByClassName("nav-secondary")[0];function hidemenu_button(e,n,t){null!=navsecondary&&(navsecondary.hidden=!1),null!=menu_container&&(menu_container.hidden=!1),null!=search_container&&(search_container.hidden=!1)}function showmenu_button(e,n,t){null!=search_container&&(null==search_button&&((search_button=e.createElement("button")).setAttribute("id","search_button"),search_button.setAttribute("class","open"),search_button.setAttribute("aria-expanded","false"),search_button.setAttribute("aria-controls","menu_container"),search_button.innerHTML='<span class="label">'+search_open+'</span><span class="icon">&nbsp;</span>',buttons_container.appendChild(search_button)),null!=search_button&&(search_button.classList.remove("init"),search_button.classList.add("closed"),search_container.classList.remove("init"),search_container.classList.add("closed"),search_container.hidden=!0,search_container.setAttribute("aria-expanded","false"),search_button.addEventListener("click",(function(){search_container.classList.contains("closed")?(search_container.classList.remove("closed"),search_container.classList.add("opened"),search_container.setAttribute("aria-expanded","true"),search_container.hidden=!1,search_button.setAttribute("aria-label",search_open),search_button.setAttribute("aria-expanded","false"),search_button.classList.remove("closed"),search_button.classList.add("opened"),search_button.querySelector(".label").innerHTML=search_close):(search_container.classList.add("closed"),search_container.classList.remove("opened"),search_container.setAttribute("aria-expanded","false"),search_container.hidden=!0,search_button.setAttribute("aria-label",search_close),search_button.setAttribute("aria-expanded","true"),search_button.classList.remove("opened"),search_button.classList.add("closed"),search_button.querySelector(".label").innerHTML=search_close)}),!1))),null!=menu_container&&(null==menu_button&&((menu_button=e.createElement("button")).setAttribute("id","menu_button"),menu_button.setAttribute("class","closed"),menu_button.setAttribute("aria-expanded","false"),menu_button.setAttribute("aria-controls","menu_container"),menu_button.innerHTML='<span class="label">'+menu_open+'</span><span class="icon">&nbsp;</span>',buttons_container.appendChild(menu_button)),null!=menu_button&&(menu_button.classList.remove("init"),menu_button.classList.add("closed"),menu_container.classList.remove("init"),menu_container.classList.add("closed"),menu_container.hidden=!0,menu_container.setAttribute("aria-expanded","false"),menu_button.addEventListener("click",(function(){menu_container.classList.contains("closed")?(menu_container.classList.remove("closed"),menu_container.classList.add("opened"),menu_container.setAttribute("aria-expanded","true"),menu_container.hidden=!1,menu_button.setAttribute("aria-label",menu_open),menu_button.setAttribute("aria-expanded","true"),menu_button.classList.remove("closed"),menu_button.classList.add("opened"),menu_button.querySelector(".label").innerHTML=menu_close):(menu_container.classList.add("closed"),menu_container.classList.remove("opened"),menu_container.setAttribute("aria-expanded","false"),menu_container.hidden=!0,menu_button.setAttribute("aria-label",menu_close),menu_button.setAttribute("aria-expanded","false"),menu_button.classList.remove("opened"),menu_button.classList.add("closed"),menu_button.querySelector(".label").innerHTML=menu_close)}),!1))),null!=navsecondary&&(navsecondary.hidden=!0)}function WidthChange(e){e.matches?hidemenu_button(document,window):showmenu_button(document,window)}var mq=window.matchMedia("(min-width: 760px)");mq.addListener(WidthChange),WidthChange(mq);