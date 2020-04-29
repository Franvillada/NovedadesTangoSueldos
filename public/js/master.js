if(document.getElementById('menu_maestros')){
    var t = document.getElementById('table')
    var rows = t.rows
    for (var i=0; i<rows.length; i++) {
        rows[i].onclick = function () {
            document.getElementById('editar').classList.remove('display_none')
            document.getElementById('cambiar_estado').classList.remove('display_none')
            document.getElementById('nuevo').classList.remove('btn-success')
            if(this.cells[this.cells.length - 1].innerHTML == 'Habilitado'){
                document.getElementById('cambiar_estado').innerHTML = 'Inhabilitar'
                document.getElementById('cambiar_estado').classList.add('btn-danger')
                document.getElementById('cambiar_estado').classList.remove('btn-success') 
            }else{
                document.getElementById('cambiar_estado').innerHTML = 'Habilitar'
                document.getElementById('cambiar_estado').classList.add('btn-success')
                document.getElementById('cambiar_estado').classList.remove('btn-danger')
            }
            if (this.parentNode.nodeName == 'THEAD') {
                return
            }
            var t = document.getElementById('table')
            var rows = t.rows
            for (var i=0; i<rows.length; i++) {
                rows[i].style.backgroundColor = 'white'
            }
            this.style.backgroundColor = 'grey'
            var f1 = document.getElementById('editar_input')
            var f2 = document.getElementById('cambiar_estado_input')
            f1.value = this.cells[0].innerHTML
            f2.value = this.cells[0].innerHTML
        }
        rows[i].onmouseover = function() {
            if (this.parentNode.nodeName == 'THEAD') {
                return
            }
            if(this.style.backgroundColor == 'grey'){
                return    
            }
            this.style.backgroundColor = 'lightgrey'
        }
        rows[i].onmouseout = function() {
            if(this.style.backgroundColor == 'grey'){
                return    
            }
            this.style.backgroundColor = 'white'
        }
    }
    
}