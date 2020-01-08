<template>
  <div class="example">
    <!-- <div class="col-md-4">
      <label>Trimestre</label>
      <select type="text" class="form-control" v-model="trimestre" @change="getAvance()">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
      </select>
    </div> -->
    <!--reporte por trimestre-->
    <apexcharts width="500" height="350" type="bar" :options="chartOptions" :series="series"></apexcharts>
  </div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'

export default {
  name: 'Chart',
  components: {
    apexcharts: VueApexCharts,
  },
  data: function() {
    return {
      chartOptions: {
        chart: {
          id: 'Gráfico de barras'
        },
        xaxis: {
          categories: ["OPC","UPCyRM","UCAP","UIS"]
        }
      },
      series: [{
        name: 'Cumplimiento',
        data: []
      }],
      trimestre:null
    }
  },
  created(){
    this.getOficinas();
  },
  mounted(){},
  methods:{
    getOficinas()
    {
      axios.get('getOficinas')
      .then(data=>
            {
                // this.chartOptions.xaxis.categories  = data.data.array;
                this.series[0].data                 = data.data.montos;
                console.log(this.series[0].data);
            }
            ).catch(error=>{
                console.log(error);
            })
    },
    // getAvance()
    // {
    //   var t = this.trimestre;
    //   axios.get('/avanceTrimestral/'+t)
    //   .then(data=>
    //         {
    //             this.series[0].data                 = data.data.montos;
    //             console.log(this.series[0].data);
    //         }
    //         ).catch(error=>{
    //             console.log(error);
    //         })
    // }
  },
}
</script>
