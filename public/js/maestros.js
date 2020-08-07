if(document.getElementById('menu_maestros')){
    var t = document.getElementById('table')
    var rows = t.rows
    for (var i=0; i<rows.length; i++) {
        rows[i].onclick = function () {
            if (this.parentNode.nodeName == 'THEAD') {
                return
            }else{
                if(document.getElementById('editar')){
                    document.getElementById('editar').classList.remove('display_none')
                    if(this.cells[this.cells.length - 1].innerHTML == 'Habilitado'){
                        document.getElementById('cambiar_estado').innerHTML = 'Inhabilitar'
                        document.getElementById('cambiar_estado').classList.add('btn-danger')
                        document.getElementById('cambiar_estado').classList.remove('btn-success') 
                    }else if(this.cells[this.cells.length - 1].innerHTML == 'Inhabilitado'){
                        document.getElementById('cambiar_estado').innerHTML = 'Habilitar'
                        document.getElementById('cambiar_estado').classList.add('btn-success')
                        document.getElementById('cambiar_estado').classList.remove('btn-danger')
                    }else if(this.cells[this.cells.length - 1].innerHTML == 'Informado'){
                        if(document.getElementById('cambiar_estado')){
                            document.getElementById('cambiar_estado').innerHTML = 'Abrir'
                            document.getElementById('cambiar_estado').classList.add('btn-danger')
                        }
                        document.getElementById('editar').classList.add('display_none')
                        document.getElementById('eliminar').classList.add('display_none')
                    }
                    var f1 = document.getElementById('editar_input')
                    f1.value = this.cells[0].innerHTML
                }
                if(document.getElementById('cambiar_estado')){
                    document.getElementById('cambiar_estado').classList.remove('display_none')
                    
                }
                if(this.cells[this.cells.length - 1].innerHTML == 'Abierto'){
                    if(document.getElementById('cambiar_estado')){
                        document.getElementById('cambiar_estado').classList.add('display_none')    
                    }
                    document.getElementById('eliminar').classList.remove("display_none")
                }
                var rows = document.getElementById('table').rows
                for (var i=0; i<rows.length; i++) {
                    rows[i].style.backgroundColor = 'white'
                    rows[i].style.fontWeight = '100'
                }
                this.style.backgroundColor = 'grey'
                this.style.fontWeight = 'bold'
                if(document.getElementById('cambiar_estado_input')){
                    var f2 = document.getElementById('cambiar_estado_input')
                    f2.value = this.cells[0].innerHTML
                }
                
                if(document.getElementById('eliminar_input')){
                    var f3 = document.getElementById('eliminar_input')
                    f3.value = this.cells[0].innerHTML
                }
            }
            
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