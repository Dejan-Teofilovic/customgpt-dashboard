import{f as y}from"./forwardRefs.54bb1675.js";import{a3 as C,a4 as S,a5 as D,a6 as M,a7 as O,k as b,a8 as h,a9 as w,D as x,K as $,p as m,aa as k,a2 as v}from"./main.a51c163a.js";import{m as A,V as I,u as R,a as p,f as T,b as U}from"./scopeId.7efb39da.js";const q=C()({name:"VMenu",props:{id:String,...S(A({closeDelay:250,closeOnContentClick:!0,locationStrategy:"connected",openDelay:300,scrim:!1,scrollStrategy:"reposition",transition:{component:I}}),["absolute"])},emits:{"update:modelValue":a=>!0},setup(a,f){let{slots:r}=f;const t=D(a,"modelValue"),{scopeId:V}=R(),g=M(),i=O(()=>a.id||`v-menu-${g}`),u=b(),e=h(p,null);let n=0;w(p,{register(){++n},unregister(){--n},closeParents(){setTimeout(()=>{n||(t.value=!1,e==null||e.closeParents())},40)}}),x(t,l=>{l?e==null||e.register():e==null||e.unregister()});function P(){e==null||e.closeParents()}return $(()=>{const[l]=T(a);return m(U,v({ref:u,class:["v-menu"]},l,{modelValue:t.value,"onUpdate:modelValue":o=>t.value=o,absolute:!0,activatorProps:v({"aria-haspopup":"menu","aria-expanded":String(t.value),"aria-owns":i.value},a.activatorProps),"onClick:outside":P},V),{activator:r.activator,default:function(){for(var o,c=arguments.length,d=new Array(c),s=0;s<c;s++)d[s]=arguments[s];return m(k,{root:!0},{default:()=>[(o=r.default)==null?void 0:o.call(r,...d)]})}})}),y({id:i},u)}});export{q as V};
