<template>
    <div id='appAlumno'>
        <form @submit.prevent="guardarAlumno" @reset.prevent="nuevoAlumno" method="post" id="frmAlumno">
            <div class="card mb-3">
                <div class="card-header text-white bg-dark">
                    Administracion de Alumnos
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="alert" data-bs-target="#frmAlumno" aria-label="Close"></button>
                </div>
                <div class="card-body">
                    <div class="row p-1">
                        <div class="col col-md-1">Codigo</div>
                        <div class="col col-md-2">
                            <input v-model="alumno.codigo" placeholder="codigo" pattern="[A-Z0-9]{3,10}" required title="Codigo de alumno" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="row p-1">
                        <div class="col col-md-1">Nombre</div>
                        <div class="col col-md-2">
                            <input v-model="alumno.nombre" placeholder="escribe tu nombre" pattern="[A-Za-zÑñáéíóú ]{3,75}" required title="Nombre de alumno" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="row p-1">
                        <div class="col col-md-1">Direccion</div>
                        <div class="col col-md-2">
                            <input v-model="alumno.direccion" placeholder="donde vives" pattern="[A-Za-z0-9Ññáéíóú ]{3,100}" required title="Direccion de alumno" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="row p-1">
                        <div class="col col-md-1">Telefono</div>
                        <div class="col col-md-2">
                            <input v-model="alumno.telefono" placeholder="tu tel" pattern="[0-9]{4}-[0-9]{4}" required title="Telefono de alumno" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="row p-1">
                        <div class="col col-md-1">DUI</div>
                        <div class="col col-md-2">
                            <input v-model="alumno.dui" placeholder="tu DUI" pattern="[0-9]{8}-[0-9]{1}" required title="DUI de alumno" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3 text-center">
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                {{ alumno.msg }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-md-3 text-center">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="reset" class="btn btn-warning">Nuevo</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="card mb-3" id="cardBuscarAlumno">
            <div class="card-header text-white bg-dark">
                Busqueda de Alumnos
                <button type="button" class="btn-close bg-white" data-bs-dismiss="alert" data-bs-target="#cardBuscarAlumno" aria-label="Close"></button>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <td colspan="6">
                                Buscar: <input title="Introduzca el texto a buscar" @keyup="buscarAlumno" v-model="buscar" class="form-control" type="text">
                            </td>
                        </tr>
                        <tr>
                            <th>Codigo</th>
                            <th>Nombre</th>
                            <th>Direccion</th>
                            <th>Telefono</th>
                            <th>DUI</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in alumnos" :key="item.idAlumno" @click="modificarAlumno(item)">
                            <td>{{item.codigo}}</td>
                            <td>{{item.nombre}}</td>
                            <td>{{item.direccion}}</td>
                            <td>{{item.telefono}}</td>
                            <td>{{item.dui}}</td>
                            <td>
                                <button type="button" class="btn btn-danger" @click="eliminarAlumno(item)">Eliminar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['form'],
        data:()=>{
            return {
                clumnos: [],
                buscar: '',
                clumno: {
                    accion: 'nuevo',
                    msg : '',
                    idAlumno: '',
                    codigo: '',
                    nombre: '',
                    direccion: '',
                    telefono: '',
                    dui: ''
                }
            }
        },
        methods: {
            buscarAlumno(){
                this.obtenerDatos(this.buscar);
            },
            sincronizarDatosServidor(clumno=''){
                fetch(`modulos/clumno/clumno.php?clumno=${JSON.stringify(clumno)}&
                    accion=recibir_datos`,
                    {credentials:'same-origin'})
                    .then(res=>res.json())
                    .then(data=>{
                        this.clumno.msg = 'Alumno sincronizado con exito en el servidor';
                    })
                    .catch(err=>{
                        this.clumno.msg = `Error al sincronizar el clumno en el servidor: ${err}`
                    });
            },
            guardarAlumno(){
                if( this.clumno.accion == 'nuevo' ){
                    this.clumno.idAlumno = idUnicoFecha();
                }
                let store = this.abrirStore('clumnos','readwrite'),
                    query = store.put(this.clumno);
                query.onsuccess=e=>{
                    this.sincronizarDatosServidor(this.clumno);
                    this.clumno.msg = 'Alumno procesado con exito';
                    this.nuevoAlumno();
                    this.obtenerDatos();
                };
                query.onerror=e=>{
                    this.clumno.msg = 'Error al procesar el clumno';
                };
            },
            modificarAlumno(data){
                this.clumno = JSON.parse(JSON.stringify(data));
                this.clumno.accion = 'modificar';
            },
            eliminarAlumno(data){
                if( confirm(`¿Esta seguro de eliminar el clumno ${data.nombre}?`) ){
                    let store = this.abrirStore('clumnos','readwrite'),
                        query = store.delete(data.idAlumno);
                    query.onsuccess=e=>{
                        data.accion = 'eliminar';
                        this.sincronizarDatosServidor(data);
                        this.clumno.msg = 'Alumno eliminado con exito';
                        this.nuevoAlumno();
                        this.obtenerDatos();
                    };
                    query.onerror=e=>{
                        this.clumno.msg = `Error al procesar el clumno ${e.target.error}`;
                    };
                }
            },
            obtenerDatos(busqueda=''){
                let store = this.abrirStore('clumnos', 'readonly'),
                    data = store.getAll();
                data.onsuccess = resp=>{
                    if( data.result.length<=0 ){
                        fetch(`modulos/clumno/clumno.php?accion=obtener_datos`,
                            {credentials:'same-origin'})
                            .then(res=>res.json())
                            .then(data=>{
                                this.clumnos = data;
                                this.clumno.msg = 'Alumnos obtenidos con exito';

                                data.map(clumno=>{
                                    let store = this.abrirStore('clumnos','readwrite'),
                                        query = store.put(clumno);
                                    query.onsuccess=e=>{
                                        this.clumno.msg = 'Alumnos guardados en local';
                                    };
                                    query.onerror=e=>{
                                        this.clumno.msg = `Error al obtener clumnos ${e.target.error}`;
                                    };
                                });
                            })
                            .catch(err=>{
                                this.clumno.msg = `Error al sincronizar el clumno en el servidor: ${err}`
                            });
                    }
                    this.clumnos = data.result.filter(clumno=>clumno.nombre.toLowerCase().indexOf(busqueda.toLowerCase())>-1);
                };
                data.onerror = e=>{
                    this.clumno.msg = `Error al obtener los datos ${e.target.error}`;
                };
            },
            nuevoAlumno(){
                this.clumno.accion = 'nuevo';
                this.clumno.idAlumno = '';
                this.clumno.codigo = '';
                this.clumno.nombre = '';
                this.clumno.direccion = '';
                this.clumno.telefono = '';
                this.clumno.dui = '';
                this.clumno.msg = '';
            },
            abrirStore(store, modo){
                let tx = db.transaction(store, modo);
                return tx.objectStore(store);
            }
        },
        created(){
            //this.obtenerDatos();
        }
    }
</script>
