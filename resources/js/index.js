$(".dropdown-menu a").click(function(){
    const icon = $(this).find('i');
    const iconClass = icon.attr('class');
    const dropdownMenu = icon.parent().parent().parent().find('i').first().attr('class', iconClass);
    console.log(icon.parent()[0]);
 });

console.log("!!!!!!!!!!!!!")

