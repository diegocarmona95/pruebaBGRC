<template>
    <div class="container">
        <h3> Registros de Vehiculos y Personas </h3>
        
        <div class="yearTable">
            <h4>Cantidad de vehiculos por año</h4>
            <b-table 
            striped hover 
            id="tabla-vehiculos"
            :items="vehiculosPorYear" 
            :fields="fieldsYear"
            >
            </b-table>
        </div>

        <div class="yearTable">
            <h4>Datos historicos vehiculos</h4>
            <b-form>
                 <b-form-group id="input-group-1" label="Dueño:" label-for="input-1">
                    <b-form-select v-model="dueno" @change="onCambioPersona">
                        <option :value="null" disabled>-- Seleccione al dueño --</option>
                        <option v-for="persona in personas" :value="persona.id" :key="persona.id">
                            {{ persona.nombre + ' ' + persona.apellidos }}
                        </option>
                    </b-form-select>
                    <b-button @click="resetearBusqueda" variant="warning" size="sm">
                        Cancelar
                    </b-button>
                </b-form-group>
            </b-form>
            <b-table 
            striped hover 
            id="tabla-historico"
            :items="vehiculosHistorico" 
            :fields="fieldsHistorico"
            >
            <template #cell(persona)="data">
                <div v-if="data.item.personas[0]">  
                    {{ data.item.personas[0].nombre + ' ' + data.item.personas[0].apellidos }} 
                </div>
                <div v-else>
                    Sin Dueño
                </div>
            </template>
             <template #cell(marca)="data">
                {{ data.item.vehiculos[0].marca }} 
            </template>
             <template #cell(modelo)="data">
                {{ data.item.vehiculos[0].modelo }} 
            </template>
              <template #cell(anno)="data">
                {{ data.item.vehiculos[0].anno }} 
            </template>
            </b-table>
        </div>
    </div>
</template>

<script>

export default {
components:{},
data(){
    return{
        vehiculosPorYear:[],
        vehiculosHistorico:[],
        personas:[],
        dueno:null,
        fieldsYear:[{ key: 'anno', label: 'Año Vehiculo' }, {key: 'cantidad_vehiculos', label: 'Cantidad'}],
        fieldsHistorico:[{key: 'persona', label:'Dueño'},{key: 'marca', label: 'Marca'}, {key:'modelo', label:'Modelo'}, {key: 'anno', label: 'Año Modelo'}]
    }
},
created(){
    this.listarPersonas();
    this.vehiculosPorAnno();
    this.historicoVehiculosPersonas();
},
methods:{
    historicoVehiculosPersonas(){
        axios.post('/historico', {
            dueno: this.dueno
        })
        .then((response) => {
            this.vehiculosHistorico = response.data.historico_vehiculo_persona;
        })
        .catch((error) => {
            console.log(error);
        })
        .finally((e) =>{

        }); 
    },
     vehiculosPorAnno(){
        axios.get('/vehiculosPorAnno', {
        })
        .then((response) => {
            this.vehiculosPorYear = response.data.vehiculos;
        })
        .catch((error) => {
            console.log(error);
        })
        .finally((e) =>{

        }); 
    },

    listarPersonas(){
        axios.get('/listarPersonas', {
        })
        .then((response) => {
            this.personas = response.data.personas; 
        })
        .catch((error) => {
            console.log(error);
        })
        .finally((e) =>{

        }); 
    },

    onCambioPersona(){
        this.historicoVehiculosPersonas();
    },
    resetearBusqueda(){
        this.dueno = null;
        this.historicoVehiculosPersonas(); 
    }
}
}
</script>

<style lang="scss" scoped>
    .container{
        padding-top:5%;
    }
    .yearTable{
        padding-top:3%;
    }
</style>