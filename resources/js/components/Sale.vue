<template>
    <main class="main">
        <div class="">
            <div class="row justify-content-center">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 style="width: 100px, margin-right: 40px">Prueba Ventas</h3>
                            <h4> Dev for: Jonay Medina</h4>

                        </div>
                        <div class="card-header">
                            
                            <button type="button" class="btn btn-success" @click="openModal('product','register')">&nbsp;&nbsp; Agregar Nuevo
                            </button>
                        </div>

                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <select class="form-control " v-model="criterion">
                                          <option value="name">Nombre</option>
                                          <option value="store">Bodega</option>
                                        </select>
                                        <input type="text" v-model="search" @keyup.enter="listProduct(1,search,criterion)" class="form-control" placeholder="Producto o bodega a buscar">
                                        <button type="submit" @click="listProduct(1,search,criterion)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>bodega</th>
                                        <th>Cantidad</th>
                                        <th>Estado</th>
                                        <th>Gestión</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="product in arrayProduct" :key="product.id">
                                        <td v-text="product.name"></td>
                                        <td v-text="product.store"></td>
                                        <td v-text="product.stock"></td>

                                        <td>
                                            <div v-if="product.status">
                                                <span class="badge badge-success">Activo</span>
                                            </div>

                                            <div v-else>
                                                <span class="badge badge-secondary">Inactivo</span>
                                            </div>
                                        </td>
                                        <td>
                                            <button v-if="product.status == 1" type="button" @click="openModal('product','desactive',product)" class="btn btn-danger btn-sm" >
                                              &nbsp;&nbsp;Suspender
                                            </button>
                                            <button v-else type="button" @click="openModal('product','active',product)" class="btn btn-success btn-sm" >
                                              &nbsp;&nbsp;Activar
                                            </button>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            <nav>
                                <ul class="pagination">
                                    <li class="page-item" v-if="pagination.current_page > 1">
                                        <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page -1, search, criterion)">Ant</a>
                                    </li>
                                    <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActive ? 'active' : '']">
                                        <a class="page-link" href="#" @click.prevent="changePage(page, search, criterion)" v-text="page"></a>
                                    </li>

                                    <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                        <a class="page-link" href="#" @click.prevent="changePage(pagination.current_page +1, search, criterion)">Sig</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Inicio del modal agregar/-->
            <div class="modal fade" tabindex="-1" :class="{'show' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="titleModal"></h4>
                            <button type="button" class="close" @click="closeModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre Producto</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="name" class="form-control" placeholder="Nombre Producto">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="stock">Cantidad de Producto</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="stock" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="store">Bodega</label>
                                    <div class="col-md-5">
                                        <select class="form-control" v-model="store" required>
                                            <option default value="no" >Seleccione</option>
                                            <option value="centro" >Centro</option>
                                            <option value="oriente" >Oriente</option>
                                            <option value="occidente" >Occidente</option>
                                            <option value="sur" >Sur</option>
                                        </select>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="closeModal()">Cerrar</button>
                            <button v-if="actionType==1" type="button" class="btn btn-primary" @click="registerProduct()">Guardar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
             <div class="modal fade" tabindex="-1" :class="{'show' : modal1}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-danger" role="document">
                    <div v-if="status == 1" class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Cambiar Estado de Producto</h4>

                            <button type="button" class="close"data-dismiss="modal" aria-label="Close" @click="closeModal()">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Estas seguro de querer cambiar el Estado ha Inactivo?</p>
                            <p>Pulse Suspender</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="closeModal()">Cancelar</button>
                            <button type="button" class="btn btn-danger" @click="desactiveProduct()">Suspender</button>

                        </div>
                    </div>
                    <div v-else-if="status==0" class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Activar Cliente</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Pulse Activar para cambiar el estado ha Activo??</p>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="closeModal()">Cancelar</button>
                            <button type="button" class="btn btn-success" @click="activeProduct()">Activar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- Fin del modal Eliminar -->
    </main>
</template>

<script>

    // import 'vue-select/dist/vue-select.css';

    export default {
        data (){
            return {
                id:0,
                name:'',
                stock:'',
                store:'',
                status:'',
                arrayProduct: [],
                modal:0,
                modal1:0,
                titleModal: '',
                acctionType:0,
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                criterion : 'name',
                search:'',
                actionType : 0,
                errorProduct : 0,

            }
        },
        computed: {
            isActive: function(){
                return this.pagination.current_page;
            },
            //esta calcula los elementos de la paginacion
            pagesNumber: function(){
                if(!this.pagination.to) {
                    return[];
                }
                var from = this.pagination.current_page - this.offset;
                if(from < 1) {
                    from = 1;
                }


                var to = from + (this.offset * 2);
                if (to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray = [];
                while(from <= to ){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods : {
            listProduct (page,search,criterion){

                let me=this;

                var url='product?page=' + page + '&search=' + search + '&criterion=' + criterion;
                axios.get(url).then(function(response) {
                    var response = response.data;
                     me.arrayProduct = response.products.data;
                     me.pagination = response.pagination;
                     // console.log(url);
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            changePage(page, search, criterion){
                let me = this;
                // actualiza la pagina
                me.pagination.current_page = page;
                // envia la peticion para visualizar la data de esa pagina
                me.listProduct(page, search, criterion);

            },
            registerProduct (){

                
                    let me=this;
                    me.dim=1;
                    axios.post('product/register', {
                        'name': this.name,
                        'store': this.store,
                        'stock': this.stock,
                    }).then(function(response) {
                        me.closeModal();
                        me.listProduct(1,'','name');
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
               

            },
            desactiveProduct(){
                let me = this;

                axios.put('product/desactive', {
                    'id': this.id,
                }).then(function (response) {
                    me.closeModal();
                    me.listProduct(1,'', 'name');
                })
                .catch(function (error) {
                   console.log(error);
                });
            },
            activeProduct(){
                let me = this;

                axios.put('product/active', {
                    'id': this.id,
                }).then(function (response) {
                    me.closeModal();
                    me.listProduct(1,'', 'name');
                }).catch(function (error) {
                    console.log(error);
                });
            },

            closeModal(){
                this.modal=0;
                this.modal1=0;
                this.errorSms=0;
                this.titleModal= '';

                this.id= 0;
                this.name='';
                this.store='centro';
                this.stock=0;
                this.status='';
            },
            openModal(modelo, accion, data = []){
                switch(modelo) {
                    case "product" :
                    {
                        switch(accion){
                            case 'register':
                            {
                                this.titleModal    = 'Registrar Producto';
                                this.modal          = 1;
                                this.actionType     = 1;

                                this.name='';
                                this.store='centro';
                                this.stock=0;
                                break;
                            }
                            case 'update':
                            {
                                this.titleModal ='Actualizar Producto';
                                this.modal      = 1;
                                this.id  = data['id'];
                                this.name       = data['name'];
                                this.store      =data['store'];
                                this.stock   = data['stock'];
                                this.actionType   = 2;
                                break;
                            }
                            case 'desactive':
                            {
                                this.modal1 = 1;
                                this.id = data['id'];
                                this.status = data['status'];
                                break;
                            }
                            case 'active':
                            {
                                this.modal1 = 1;
                                this.id = data['id'];
                                break;
                            }
                        }
                    }
                }

            }
        },
        mounted() {
            this.listProduct(1,this.search,this.name);
        }
    }
</script>
