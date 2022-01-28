$(document).ready(function(){
  var form = $('.familyForm');
  var firstName    = form.find('input:first-child');
      lastName     = form.find('input:nth-child(2)');
      age          = form.find('input:nth-child(3)');
      relation     = form.find('input:nth-child(4)');
      radioBtn     = form.find("input[type='radio']");
  var button = form.find('button');

  button.attr('disabled', true);
  button.css("text-decoration", "line-through");
  $("input[type='text'], input[type='radio']").change(function(){
    if( firstName.val() != "" && lastName.val() != "" && age.val() != "" && relation.val() != "" && radioBtn.is(':checked')){
        button.attr('disabled', false);
        button.css("text-decoration", "none");
    }
    else{
      button.attr('disabled', true);
    }
  })
})