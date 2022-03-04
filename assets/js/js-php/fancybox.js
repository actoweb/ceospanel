/*
 * only fancyboxes scripts
 * */


//fecha qualquer janela fancy através de link
$(document).on("click","a.closeFancy", function(e){
  $.fancybox.close();
});


//janela de selecao do formato de etiqueta para impressao
$(document).on("click","a#btn-etiquetas-all", function(e){
  $.fancybox({
      type: 'ajax',
      href: 'ajax.php?win=closebox',
      padding: 0,
      autoSize: true,
      closeClick  : false, // prevents closing when clicking INSIDE fancybox
      openEffect  : 'none',
      closeEffect : 'none',
      helpers   : {
      overlay : {closeClick: false} // prevents closing when clicking OUTSIDE fancybox
    }
   }).trigger("click");
});


//janela fancy com instrucoes para importacao de excel data
$(document).on("click","a.fancyImportProdWin", function(){
  var uid = $(this).attr("data-info");
  $.fancybox({
    type: 'ajax',
    href: 'ajax.php?win=import&modulo='+uid,
    padding: 0,
    autoSize: true
  });
});
