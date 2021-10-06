<template>
    <div class="container">
        <h3> Personas </h3> 

        <div class="form">
            <b-form @submit="registrarPersona" @reset="resetPersona">
                <b-form-group label="Nombre:">
                    <b-form-input
                        id="input-1"
                        type="text"
                        v-model="persona.nombre"
                        placeholder="Nombre"
                        required>
                    </b-form-input>
                </b-form-group>

                <b-form-group label="Apellidos:">
                    <b-form-input
                        id="input-2"
                        type="text"
                        v-model="persona.apellidos"
                        placeholder="Apellidos"
                        required>
                    </b-form-input>
                </b-form-group>

                 <b-form-group label="Correo:">
                    <b-form-input
                        id="input-3"
                        type="email"
                        v-model="persona.correo"
                        placeholder="Correo"
                        required>
                    </b-form-input>
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
                id="tabla-personas"
                :items="personas" 
                :fields="fields"
                :current-page="currentPage"
                :per-page="perPage"
                >
                    <template #cell(actions)="row">
                        <b-button size="sm" variant="primary" @click="editarPersona(row)">
                             Editar
                        </b-button>
                        <b-button size="sm" variant="danger" @click="eliminarPersona(row)">
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
                    aria-controls="tabla-personas"
                    @change="handlePageChange">
                </b-pagination>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isBusy:false,
            totalRows: 1,
            currentPage: 1,
            perPage: 5,
            counter: 0,
            personas:[],
            persona:{
                id: 0,
                nombre: null,
                apellidos: null,
                correo: null
            },
            fields:['id','nombre','apellidos','correo', { key: 'actions', label: 'Acciones' }],
            dismissSecs: 3,
            dismissCountDown: 0,
            showDismissibleAlert: false,
            message: '',
            variantMessage: '',
            accionBoton: 'Registrar'
        }
    },
    created(){
        this.listarPersonasTabla();
    },
    methods:{
        listarPersonasTabla(){
            this.isBusy = true;
            axios.get('/listarPersonasTabla', {
                current_page: this.currentPage,
                per_page:this.perPage
            })
            .then((response) => {
                this.personas = response.data.personas.data; 
                this.totalRows = response.data.personas.total;
            })
            .catch((error) => {
                console.log(error);
            })
            .finally((e) =>{
                this.isBusy = false;
            }); 
        },

        editarPersona(row){
            this.accionBoton = 'Actualizar'
            this.persona.id = row.item.id
            this.persona.nombre = row.item.nombre
            this.persona.apellidos = row.item.apellidos
            this.persona.correo = row.item.correo
        },

        eliminarPersona(row){
            axios.post('/eliminarPersona', {
                id: row.item.id
            })
            .then((response) => {
                if(response.data.status == 'ok'){
                    this.variantMessage = 'success';
                    this.message = 'El usuario ha sido eliminado';
                    this.dismissCountDown = this.dismissSecs
                    this.listarPersonasTabla();
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

        handlePageChange(value) {
            this.currentPage = value;
            this.listarPersonas();
        },

        resetPersona(){
            this.persona.id = 0;
            this.persona.nombre = null;
            this.persona.apellidos = null;
            this.persona.correo = null; 
            this.accionBoton = 'Registrar'
        },

        registrarPersona(event){
            event.preventDefault()
            axios.post('/registrarActualizarPersona', {
                persona: this.persona
            })
            .then((response) => {
                if(response.data.status == 'ok'){
                    this.variantMessage = 'success';
                    this.message = this.persona.id == 0 ? 'El usuario ha sido registrado': 'El usuario ha sido actualizado';
                    this.dismissCountDown = this.dismissSecs
                    this.listarPersonasTabla();
                    this.resetPersona();
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

        countDownChanged(dismissCountDown) {
            this.dismissCountDown = dismissCountDown
        },
    }
}
</script>

<style lang="scss" scoped>
    .container{
        padding-top:5%;
    }
    .form{
        padding-top:5%;
    }
    .table{
        padding-top:5%;
    }
    .alerta{
        height:40px
    }
    .cont-botones{
        padding-top:20px;
        position: relative;
        right: 0;
    }
</style>