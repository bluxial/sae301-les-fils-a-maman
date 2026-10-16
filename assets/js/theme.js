/* Navigation accessible, quantités natives et panier WooCommerce. */
document.addEventListener('DOMContentLoaded',()=>{
 const menu=document.querySelector('.lf-menu');
 if(menu){const nav=document.getElementById(menu.getAttribute('aria-controls'));menu.addEventListener('click',()=>{const expanded=menu.getAttribute('aria-expanded')!=='true';menu.setAttribute('aria-expanded',String(expanded));menu.setAttribute('aria-label',expanded?'Fermer le menu':'Ouvrir le menu');nav.classList.toggle('is-open',expanded)});document.addEventListener('keydown',event=>{if(event.key==='Escape'&&menu.getAttribute('aria-expanded')==='true'){menu.click();menu.focus()}});nav.addEventListener('click',event=>{if(event.target.closest('a')&&menu.getAttribute('aria-expanded')==='true')menu.click()})}
 document.querySelectorAll('.lf-product-summary .quantity').forEach(root=>{
  const input=root.querySelector('input.qty');if(!input||input.type==='hidden')return;
  const decrease=document.createElement('button'),increase=document.createElement('button');
  decrease.type=increase.type='button';decrease.textContent='−';increase.textContent='+';decrease.setAttribute('aria-label','Diminuer la quantité');increase.setAttribute('aria-label','Augmenter la quantité');
  const sync=()=>{const min=Number(input.min||1),max=input.max?Number(input.max):Infinity;decrease.disabled=Number(input.value)<=min;increase.disabled=Number(input.value)>=max};
  const change=direction=>{if(direction>0)input.stepUp();else input.stepDown();input.dispatchEvent(new Event('change',{bubbles:true}));sync()};
  decrease.addEventListener('click',()=>change(-1));increase.addEventListener('click',()=>change(1));input.addEventListener('change',sync);root.prepend(decrease);root.append(increase);sync();
 });
});
