var GTmpl = (function(){

  var target_el = null;
  var last_template = null;
  var tmpl = {};
  var _cache = {};
  
  tmpl['default'] = '<p id="description"></p>';
  tmpl['fight'] = '<table><tr><td><table><caption id="monster_name"></caption><tr><td colspan="2" id="monster_image"></td></tr><tr><th>HP</th><td id="monster_hp"></td></tr><tr><th>MP</th><td id="monster_mp"></td></tr><tr><th>Attack</th><td id="monster_attack"></td></tr><tr><th>Defence</th><td id="monster_defence"></td></tr></table></td><td><table><caption id="hero_name"></caption><tr><td colspan="2" id="hero_image"></td></tr><tr><th>HP</th><td id="hero_hp"></td></tr><tr><th>MP</th><td id="hero_mp"></td></tr><tr><th>Attack</th><td id="hero_attack"></td></tr><tr><th>Defence</th><td id="hero_defence"></td></tr></table></td></tr></table>';

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