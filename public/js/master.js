if(document.getElementById('editar_legajo')){
    var t = document.getElementById('legajo_table')
    var rows = t.rows
    for (var i=0; i<rows.length; i++) {
        rows[i].onclick = function () {
            document.getElementById('editar_legajo').classList.remove('display_none')
            document.getElementById('eliminar_legajo').classList.remove('display_none')
            document.getElementById('nuevo_legajo').classList.remove('btn-success')
            if (this.parentNode.nodeName == 'THEAD') {
                return;
            }
            var t = document.getElementById('legajo_table')
            var rows = t.rows
            for (var i=0; i<rows.length; i++) {
                rows[i].style.backgroundColor = 'white'
            }
            this.style.backgroundColor = 'lightgrey'
            var cells = this.cells
            var f1 = document.getElementById('legajo')
            f1.value = cells[0].innerHTML
        };
    }
    
}