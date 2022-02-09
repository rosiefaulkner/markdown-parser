document.querySelector("button").onclick = function(){
    document.querySelector("textarea").select();
    document.execCommand('copy');
  };