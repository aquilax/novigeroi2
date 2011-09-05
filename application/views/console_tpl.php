<html>
<head>
  <title>NG2 Console</title>
</head>
<body>
cmd:<input name="cmd" value="user/getClasses" id="cmd" />
data:<input name="data" id="data" />
<input id="post" type="submit" />
<div id="msg">
</div>
<div id="console" style="font-size:.8em">
</div>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>

<script>

/**
 * Versao JavaScript da funcao var_dump do PHP
 * @param mixed ... Qualquer valor
 * @return string Informacoes do valor
 */
function var_dump(/* ... */) {
    
    /**
     * Recursao do metodo var_dump
     * @param midex item Qualquer valor
     * @param int nivel Nivel de indentacao
     * @return string Informacoes do valor
     */
    this.var_dump_rec = function(item, nivel) {
        if (var_dump.max_iteracoes > 0 && var_dump.max_iteracoes < nivel) {
            return this.indentar(nivel) + "*MAX_ITERACOES(" + var_dump.max_iteracoes+ ")*\n";
        }
        if (item === null) {
            return this.indentar(nivel) + "NULL\n";
        } else if (item === undefined) {
            return this.indentar(nivel) + "undefined\n";
        }

        var str = '';
        var tipo = typeof(item);
        switch (tipo) {
        case 'object':
            var classe = this.get_classe(item);
            switch (classe) {
            case 'Array':
                str += this.indentar(nivel) + "Array(" + item.length + ") {\n";
                for (var i in item) {
                    str += this.indentar(nivel + 1) + "[" + i + "] =>\n";
                    str += this.var_dump_rec(item[i], nivel + 1);
                }
                str += this.indentar(nivel) + "}\n";
                break;

            case 'Number':
            case 'Boolean':
                str += this.indentar(nivel) + classe + "(" + item.toString() + ")\n";
                break;

            case 'String':
                str += this.indentar(nivel) + classe + "(" + item.toString().length + ") \"" + item.toString() + "\"\n";
                break;
            
            default:
                str += this.indentar(nivel) + "object(" + classe + ") {\n";
                var exibiu = false;
                for (var i in item) {
                    var exibiu = true;
                    str += this.indentar(nivel + 1) + "[" + i + "] =>\n";
                    try {
                        str += this.var_dump_rec(item[i], nivel + 1);
                    } catch (e) {
                        str += this.indentar(nivel + 1) + "(Erro: " + e.message + ")\n";
                    }
                }
                if (!exibiu) {
                    str += this.indentar(nivel + 1) + "JSON(" + JSON.stringify(item) + ")\n";
                }
                str += this.indentar(nivel) + "}\n";
                break;
            }
            break;
        case 'number':
            str += this.indentar(nivel) + "number(" + item.toString() + ")\n";
            break;
        case 'string':
            str += this.indentar(nivel) + "string(" + item.length + ") \"" + item + "\"\n";
            break;
        case 'boolean':
            str += this.indentar(nivel) + "boolean(" + (item ? "true" : "false") + ")\n";
            break;
        case 'function':
            var codigo = item.toString();
            str += this.indentar(nivel) + "function {\n";
            str += this.indentar(nivel + 1) + "[code] =>\n";
            str += this.var_dump_rec(item.toString(), nivel + 1);
            str += this.indentar(nivel + 1) + "[prototype] =>\n";
            str += this.indentar(nivel + 1) + "object(prototype) {\n";
            for (var i in item.prototype) {
                str += this.indentar(nivel + 2) + "[" + i + "] =>\n";
                str += this.var_dump_rec(item.prototype[i], nivel + 2);
            }
            str += this.indentar(nivel + 1) + "}\n";

            str += this.indentar(nivel) + "}\n";
            break;
        default:
            str += this.indentar(nivel) + tipo + "(" + item + ")\n";
            break;
        }
        return str;
    };

    /**
     * Devolve o nome da classe de um objeto
     * @param Object obj Objeto a ser verificado
     * @return string Nome da classe
     */
    this.get_classe = function(obj) {
        if (obj.constructor) {
            return obj.constructor.toString().replace(/^.*function\s+([^\s]*|[^\(]*)\([^\x00]+$/, "$1");
        }
        return "Object";
    };

    /**
     * Retorna espacos para identacao
     * @param int nivel Nivel de identacao
     * @return string Espacos de identacao
     */
    this.indentar = function(nivel) {
        var str = '';
        while (nivel > 0) {
            str += '  ';
            nivel--;
        }
        return str;
    };

    var str = "";
    var argv = var_dump.arguments;
    var argc = argv.length;
    for (var i = 0; i < argc; i++) {
        str += this.var_dump_rec(argv[i], 0);
    }
    return str;
}
var_dump.prototype.max_iteracoes = 0;

</script>



<script type="text/javascript">
$base = '/v1/';

function addNode(req, resp){
  var ts = new Date().toString();
  var el = '<div>['+ts+'] <b>'+req+'</b><br/><pre>'+var_dump(resp)+'</pre></div>';
  $(el).prependTo('#console');
}
$("#console").ajaxError(function(event, request, settings, text){
  $('<div style="color:red">'+request.status+' '+text+' : '+ settings.url + "</div>").prependTo(this);
});
$('#post').click(function(event){
  $url = $base + $('#cmd').val();
  $.post($url, $('#data').val(), function(data){
    addNode($url, data);
  });
  event.preventDefault();
})
</script>
</body>
</html>
