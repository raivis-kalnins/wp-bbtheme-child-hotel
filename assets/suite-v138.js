(function(W,D){
  'use strict';

  var cards = [
    ['Room discovery','Compare room types, capacity, amenities and practical stay details in one clear journey.'],
    ['Stay planning','Bring dining, local recommendations and useful arrival information into the booking experience.'],
    ['Direct enquiries','Capture dates, guest needs and special requests so the hotel team can respond with the right context.']
  ];

  function q(selector,root){try{return (root||D).querySelector(selector);}catch(e){return null;}}
  function kids(node){return node?Array.prototype.slice.call(node.children||[]):[];}
  function text(node){return String(node&&node.textContent||'').replace(/\s+/g,' ').trim();}
  function norm(value){return String(value||'').toLowerCase().replace(/[^a-z0-9]+/g,' ').replace(/\s+/g,' ').trim();}

  function markBody(){if(D.body)D.body.classList.add('wpbb-v138');}

  function rowCells(row){
    var cells=kids(row).filter(function(cell){
      if(!cell || cell.nodeType!==1)return false;
      if(cell.classList.contains('wpbb-v136-hidden') || cell.classList.contains('wpbb-v134-empty-shell'))return false;
      return !!(text(cell) || q('article,.card,.wpbb-icon-card,.wp-theme-sector-card,h2,h3,h4,h5,h6,p,img,svg',cell));
    });
    return cells.slice(0,3);
  }

  function repairSectorRow(){
    var row=D.getElementById('wpbb-row-30');
    if(!row || !row.closest('#wp-theme-main'))return;
    var cells=rowCells(row);
    if(cells.length<3)return;

    row.classList.add('wpbb-v138-sector-grid');
    cells.forEach(function(cell,index){
      cell.classList.add('wpbb-v138-sector-cell');
      var card=q('.wp-theme-sector-card,.wpbb-icon-card,.wpbb-card,.card,[class*="card"]',cell) || cell.firstElementChild || cell;
      var title=q('.wpbb-icon-card__title,.card-title,h2,h3,h4,h5,h6,strong',card) || q('h2,h3,h4,h5,h6,strong',cell);
      var body=q('.wpbb-icon-card__text,.card-text,p',card) || q('p',cell);
      var data=cards[index];

      if(title && (norm(text(title))==='card title' || !text(title) || title.dataset.wpbbV138Demo==='1')){
        title.textContent=data[0];
        title.dataset.wpbbV138Demo='1';
      }
      if(body && (norm(text(body))==='add a short description' || !text(body) || body.dataset.wpbbV138Demo==='1')){
        body.textContent=data[1];
        body.dataset.wpbbV138Demo='1';
      }
    });
  }

  function run(){markBody();repairSectorRow();}
  var pending=false;
  function schedule(){if(pending)return;pending=true;W.setTimeout(function(){pending=false;run();},60);}

  if(D.readyState==='loading')D.addEventListener('DOMContentLoaded',schedule,{once:true});else schedule();
  W.addEventListener('load',function(){run();W.setTimeout(run,350);W.setTimeout(run,1100);});
  if(W.MutationObserver)new MutationObserver(function(changes){
    if(changes.some(function(change){return change.addedNodes&&change.addedNodes.length;}))schedule();
  }).observe(D.documentElement,{childList:true,subtree:true});
})(window,document);
