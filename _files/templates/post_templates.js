
  function pupulate(data){
    for (id in data){
      if (typeof(_cache[id]) != 'undefined'){
        _cache[id].html(data[id]);
      } else {
        var el = $('#'+id);
        if (typeof(el) != 'undefined'){
          _cache[id] = el;
          el.html(data[id]);
        }
      }
    }
  }

  function init(target) {
    target_el = $(target);
  }

  function getTemplate(template) {
    if (typeof(tmpl[template]) == "undefined"){
      template = 'default';
    }
    return tmpl[template];
  }

  function render(data, template, target) {
    var rtarget;
    if (typeof(target) != 'undefined'){
      rtarget = $(target);
    } else {
      rtarget = target_el
    }
    if (template != last_template){
      // render template
      rtarget.html(getTemplate(template));
      _cache = {}
    }
    last_template = template;
  }

  return {
    init: init,
    render: render
  };
}());