<template>
    <div class="container">
        <h3> Vehiculos </h3> 
            <!-- Formulario-->
            <div class="form">
                <b-form @submit="registrarVehiculo" @reset="resetVehiculo">
                   <b-form-group label="Marca:">
                       <b-form-select
                        v-model="vehiculo.marca"
                        required
                        >
                            <option :value="null" disabled>-- Seleccione la Marca --</option>
                            <option v-for="marca in marcas" :value="marca">
                                {{ marca}}
                            </option>
                        </b-form-select>
                    </b-form-group>
                    <b-form-group label="Modelo:">
                       <b-form-select
                        v-model="vehiculo.modelo"
                        required
                        >
                            <option :value="null" disabled>-- Seleccione el Modelo --</option>
                            <option v-for="modelo in modelos" :value="modelo">
                                {{ modelo}}
                            </option>
                        </b-form-select>
                    </b-form-group>
                     <b-form-group id="input-group-3" label="Año:" label-for="input-3">
                        <b-form-input
                        id="input-3"
                        v-model="vehiculo.anno"
                        placeholder="Año"
                        type="number"
                        required
                        ></b-form-input>
                    </b-form-group>
                    <b-form-group id="input-group-4" label="Precio:" label-for="input-4">
                        <b-form-input
                        id="input-4"
                        type="number"
                        v-model="vehiculo.precio"
                        placeholder="Precio"
                        required
                        ></b-form-input>
                    </b-form-group>
                     <b-form-group id="input-group-5" label="Dueño:" label-for="input-5">
                        <b-form-select v-model="vehiculo.dueno">
                            <option :value="null" disabled>-- Seleccione al dueño --</option>
                            <option v-for="persona in personas" :value="persona.id">
                            {{ persona.nombre + ' ' + persona.apellidos }}
                            </option>
                        </b-form-select>
                    </b-form-group>
                     <b-form-group class="cont-botones">
                        <b-button type="submit" variant="success">{{accionBoton}}</b-button>
                        <b-button type="reset" variant="warning">Cancelar</b-button>
                     </b-form-group>
                </b-form>
            </div>

            <div class="alerta">
                <b-alert
                    :show="dismissCountDown"
                    :dismissible="false"
                    fade
                    :variant="variantMessage"
                    @dismissed="dismissCountDown=0"
                    @dismiss-count-down="countDownChanged"
                    >
                    <p>{{ message }}</p>
                </b-alert>
            </div>
            
            <div class="table">
                <b-table 
                :busy="isBusy" striped hover 
                id="tabla-vehiculos"
                :items="vehiculos" 
                :fields="fields"
                :current-page="currentPage"
                :per-page="perPage"
                >
                    <template #cell(persona)="data">
                        <div v-if="data.item.persona">  
                            {{ data.item.persona.nombre + ' ' + data.item.persona.apellidos }} 
                        </div>
                        <div v-else>
                            Sin Dueño
                        </div>
                    </template>
                     <template #cell(actions)="row">
                        <b-button size="sm" variant="primary" @click="editarVehiculo(row)">
                             Editar
                        </b-button>
                        <b-button size="sm" variant="danger" @click="eliminarVehiculo(row)">
                            Eliminar
                        </b-button>
                    </template>
                </b-table>
                  <b-pagination
                    v-model="currentPage"
                    :total-rows="totalRows"
                    :per-page="perPage"
                    align="fill"
                    size="sm"
                    class="my-0"
                    aria-controls="tabla-vehiculos"
                    @change="handlePageChange"
                    ></b-pagination>
            </div>
      
    </div>
</template>

<script>
export default {
    data() {
        return {
            vehiculo:{
                id: 0,
                anno: null,
                dueno: null,
                marca: null,
                modelo: null,
                precio: 0
            },
            vehiculos: [],
            isBusy: false,
            fields: ['id', 'marca', 'modelo', 'precio', { key: 'persona', label: 'Dueño' },  { key: 'actions', label: 'Acciones' }],
            marcas: ['Kawasaki', 'Yamaha', 'KTM', 'Honda'],
            personas: [],
            totalRows: 1,
            currentPage: 1,
            perPage: 5,
            dismissSecs: 3,
            dismissCountDown: 0,
            showDismissibleAlert: false,
            message: '',
            variantMessage: '',
            accionBoton: 'Registrar'
        }
    },
    created(){
        this.listarVehiculos();
        this.listarPersonas();
    },
    methods:{
        registrarVehiculo(event){
            event.preventDefault()
            axios.post('/registrarVehiculo', {
                vehiculo: this.vehiculo
            })
            .then((response) => {
                if(response.data.status == 'ok'){
                    this.variantMessage = 'success';
                    this.message = this.vehiculo.id == 0 ? 'El vehiculo ha sido registrado': 'El vehiculo ha sido actualizado';
                    this.dismissCountDown = this.dismissSecs
                    this.listarVehiculos();
                    this.resetVehiculo();
                }else{
                    alert(response.data.errores.join(', '))
                }
                
            })
            .catch((error) => {
                console.log(error);
            })
            .finally((e) =>{
                // always executed
            }); 
        },

        listarVehiculos(){
            this.isBusy = true;
            axios.get('/listarVehiculos', {
                current_page: this.currentPage,
                per_page:this.perPage
            })
            .then((response) => {
                this.vehiculos = response.data.vehiculos.data; 
                this.totalRows = response.data.vehiculos.total;
            })
            .catch((error) => {
                console.log(error);
            })
            .finally((e) =>{
                this.isBusy = false;
            }); 
        },

        listarPersonas(){
            this.isBusy = true;
            axios.get('/listarPersonas', {
            })
            .then((response) => {
                this.personas = response.data.personas; 
            })
            .catch((error) => {
                console.log(error);
            })
            .finally((e) =>{
                this.isBusy = false;
            }); 
        },

        eliminarVehiculo(row){
            axios.post('/eliminarVehiculo', {
                id: row.item.id
            })
            .then((response) => {
                if(response.data.status == 'ok'){
                    this.variantMessage = 'success';
                    this.message = 'El vehiculo ha sido eliminado';
                    this.dismissCountDown = this.dismissSecs
                    this.listarVehiculos();
                }else{
                    alert(response.data.errores.join(', '))
                }
            })
            .catch((error) => {
                console.log(error);
            })
            .finally((e) =>{
                // always executed
            }); 
        },

        resetVehiculo(){
            this.vehiculo.anno = null;
            this.vehiculo.marca = null;
            this.vehiculo.modelo = null;
            this.vehiculo.dueno = null;
            this.vehiculo.precio = null;
            this.vehiculo.id = 0;
            this.accionBoton = 'Registrar';
        },

        editarVehiculo(row){
            this.vehiculo.marca = row.item.marca
            this.vehiculo.modelo = row.item.modelo
            this.vehiculo.anno = row.item.anno
            this.vehiculo.precio = row.item.precio
            this.vehiculo.dueno = row.item.dueno
            this.vehiculo.id = row.item.id
            this.accionBoton = 'Actualizar'
        },

        handlePageChange(value) {
            this.currentPage = value;
            this.listarVehiculos();
        }

    },
    computed:{
        modelos(){
            var modelos = [];
            switch (this.vehiculo.marca) {
                case 'Kawasaki':
                    modelos = ['Ninja 400', 'Zx10R', 'Z6xR']
                    break;
                case 'Yamaha':
                    modelos = ['MT-03', 'R3', 'R1']
                    break;
                case 'KTM':
                    modelos = ['RC 390', 'Duke 200', 'Adventure 900']
                    break;
                case 'Honda':
                    modelos = ['Storm 400', 'CBR Fireblade', 'Twister 125']
                    break;
            
                default:
                    break;
            }
            return modelos;
        }
    }
}
</script>

<style lang="scss" scoped>
    .container{
        padding-top:3%;
    }
    .form{
        padding-top:5%;
    }
    .table{
        padding-top:5%;
    }
    .cont-botones{
        padding-top:20px;
        position: relative;
        right: 0;
    }
    .alerta{
        height:40px
    }
</style>