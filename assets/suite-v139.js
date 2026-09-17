/* Hotel 3.8.11.39 - grid/card/WooCommerce runtime hardening. */
(function(W,D){
  'use strict';
  var H=D.documentElement;
  var cardCopy=[
    ['Room discovery','Compare room types, capacity, amenities and practical stay details in one clear journey.'],
    ['Stay planning','Bring dining, local recommendations and useful arrival information into the booking experience.'],
    ['Direct enquiries','Capture dates, guest needs and special requests so the hotel team can respond with the right context.']
  ];
  function q(sel,root){try{return (root||D).querySelector(sel);}catch(e){return null;}}
  function qa(sel,root){try{return Array.prototype.slice.call((root||D).querySelectorAll(sel));}catch(e){return [];}}
  function text(node){return String(node&&node.textContent||'').replace(/\s+/g,' ').trim();}
  function norm(value){return String(value||'').toLowerCase().replace(/[^a-z0-9]+/g,' ').replace(/\s+/g,' ').trim();}
  function ready(fn){if(D.readyState==='loading')D.addEventListener('DOMContentLoaded',fn,{once:true});else fn();}
  function desktop(){return W.matchMedia('(min-width: 992px)').matches;}
  function mark(){if(D.body)D.body.classList.add('wpbb-v139');}

  function menuTrigger(menu){
    var li=menu&&menu.parentElement;if(!li)return null;
    try{return li.querySelector(':scope > a, :scope > button, :scope > .wp-theme-nav-link')||li;}
    catch(e){return li.querySelector('a,button')||li;}
  }
  function positionMega(menu){
    if(!menu)return;
    if(!desktop()){menu.style.removeProperty('top');return;}
    var trigger=menuTrigger(menu);if(!trigger||!trigger.getBoundingClientRect)return;
    var r=trigger.getBoundingClientRect(),li=menu.parentElement,lr=li&&li.getBoundingClientRect?li.getBoundingClientRect():r;
    var bottom=Math.ceil(Math.max(r.bottom,lr.bottom)-6);
    if(bottom>0){menu.style.setProperty('top',bottom+'px','important');H.style.setProperty('--wpbb-v139-mega-top',bottom+'px');}
  }
  function positionMegas(){qa('.wp-theme-primary-menu>li>.wp-theme-mega-menu').forEach(positionMega);}
  function bindMegas(){
    qa('.wp-theme-primary-menu>li>.wp-theme-mega-menu').forEach(function(menu){
      if(menu.dataset.wpbbV139Bound)return;
      menu.dataset.wpbbV139Bound='1';
      var li=menu.parentElement;
      if(li){li.addEventListener('pointerenter',function(){positionMega(menu);},{passive:true});li.addEventListener('focusin',function(){positionMega(menu);});}
      menu.addEventListener('pointerenter',function(){positionMega(menu);},{passive:true});
    });
    positionMegas();
  }

  function directCell(node,row){
    var p=node;
    while(p&&p.parentElement&&p.parentElement!==row)p=p.parentElement;
    return p&&p.parentElement===row?p:null;
  }
  function findSectorRow(){
    var row=D.getElementById('wpbb-row-30');
    if(row)return row;
    var placeholders=qa('h2,h3,h4,h5,h6,strong').filter(function(el){return norm(text(el))==='card title';});
    if(placeholders.length<3)return null;
    var first=placeholders[0];
    return first.closest('[id^="wpbb-row-"],.wpbb-row,.row')||null;
  }
  function repairSectorRow(){
    var row=findSectorRow();if(!row||!row.closest('#wp-theme-main'))return;
    row.classList.add('wpbb-v138-sector-grid','wpbb-v139-sector-grid');
    var candidateTitles=qa('h2,h3,h4,h5,h6,strong',row).filter(function(el){var t=norm(text(el));return t==='card title'||el.dataset.wpbbHotelDemo==='1';}).slice(0,3);
    var cells=[];
    candidateTitles.forEach(function(title){var cell=directCell(title,row);if(cell&&cells.indexOf(cell)===-1)cells.push(cell);});
    if(cells.length<3){cells=Array.prototype.slice.call(row.children||[]).filter(function(el){return text(el);}).slice(0,3);}
    cells.slice(0,3).forEach(function(cell,index){
      cell.classList.add('wpbb-v139-sector-cell');
      var title=q('.wpbb-icon-card__title,.card-title,h2,h3,h4,h5,h6,strong',cell);
      var body=q('.wpbb-icon-card__text,.card-text,p',cell);
      if(title&&(norm(text(title))==='card title'||!text(title)||title.dataset.wpbbHotelDemo==='1')){title.textContent=cardCopy[index][0];title.dataset.wpbbHotelDemo='1';}
      if(body&&(norm(text(body))==='add a short description'||!text(body)||body.dataset.wpbbHotelDemo==='1')){body.textContent=cardCopy[index][1];body.dataset.wpbbHotelDemo='1';}
    });
  }

  function commonParent(a,b){
    if(!a||!b)return null;
    var p=a.parentElement,depth=0;
    while(p&&depth<8){if(p.contains(b))return p;p=p.parentElement;depth++;}
    return null;
  }
  function repairCart(){
    var main=q('#wp-theme-main.wp-theme-woo-legacy--cart');if(!main)return;
    var form=q('.woocommerce-cart-form',main),tot=q('.cart-collaterals',main);if(!form||!tot)return;
    var host=commonParent(form,tot);if(host)host.classList.add('wpbb-v139-cart-grid');
  }

  var endpointSlugs=['orders','downloads','edit-address','edit-account','payment-methods','lost-password','view-order','add-payment-method','delete-payment-method','set-default-payment-method','customer-logout'];
  function repairAccountLinks(){
    var main=q('#wp-theme-main.wp-theme-woo-legacy--account');if(!main)return;
    qa('a[href]',main).forEach(function(link){
      try{
        var url=new URL(link.href,W.location.href);if(url.origin!==W.location.origin)return;
        var parts=url.pathname.replace(/^\/+|\/+$/g,'').split('/').filter(Boolean);
        if(parts.length!==1||endpointSlugs.indexOf(parts[0])===-1)return;
        url.pathname='/my-account/'+parts[0]+'/';link.href=url.toString();
      }catch(e){}
    });
  }

  function run(){mark();bindMegas();repairSectorRow();repairCart();repairAccountLinks();}
  var raf=0;function queueMega(){if(raf)return;raf=W.requestAnimationFrame(function(){raf=0;positionMegas();});}
  ready(function(){run();W.setTimeout(run,120);W.setTimeout(run,650);W.setTimeout(run,1400);});
  W.addEventListener('load',function(){run();W.setTimeout(run,300);});
  W.addEventListener('resize',queueMega,{passive:true});
  W.addEventListener('scroll',queueMega,{passive:true});
  if(W.MutationObserver){
    var queued=false;
    new MutationObserver(function(ms){
      if(!ms.some(function(m){return m.addedNodes&&m.addedNodes.length;}))return;
      if(queued)return;queued=true;
      W.setTimeout(function(){queued=false;repairSectorRow();repairCart();repairAccountLinks();bindMegas();},60);
    }).observe(D.documentElement,{childList:true,subtree:true});
  }
})(window,document);
