var templates = {};
var prepare = {}

templates['default'] = "<p>{{description}}</p>"
templates['fight'] = "<table><caption>{{name}}</caption><tr><th>HP</th><td>{{hp}}</td></tr><tr><th>Defence</th><td>{{defence}}</td></tr></table>";

prepare['default'] = function (data){
  return {
    'description': data.data.description,
  }
}
prepare['fight'] = function (data){
  return {
    'name': data.data.monster.name,
    'hp': data.data.monster.hp,
    'defence': data.data.monster.defence
  };
}
