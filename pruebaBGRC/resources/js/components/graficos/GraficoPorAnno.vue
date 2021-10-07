<template>
  <div>
      <highcharts :options="chartOptions"></highcharts>
  </div>
</template>

<script>
import {Chart} from 'highcharts-vue';
export default {
name:'GraficoPorAnno',
components:{ highcharts: Chart },
props:['dataVehiculos'],
data(){
    return{
        chartOptions: {
        chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: "pie",
          credit:false
        },
        title: {
          text: "Cantidad de Vehiculo por Año"
        },
        tooltip: {
          pointFormat: "{series.name}: <b>{point.percentage:.1f}%</b>"
        },
        plotOptions: {
          pie: {
            allowPointSelect: true,
            cursor: "pointer",
            dataLabels: {
              enabled: true,
              format: "<b>{point.name}</b>: {point.percentage:.1f} %",
            },
            showInLegend: true
          }
        },
        series: [
          {
            name: "Percentage",
            colorByPoint: true,
            data: []
          }
        ]
      }
    }
},
created(){
},
methods:{
},
watch:{
    dataVehiculos(){
        this.dataVehiculos.forEach(elemento => {
            console.log(elemento)
            this.chartOptions.series[0].data.push({name: elemento.anno, y: elemento.cantidad_vehiculos})
        });
    }
}

}
</script>

<style>

</style>