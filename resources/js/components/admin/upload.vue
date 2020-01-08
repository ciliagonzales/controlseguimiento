<template>
    <div class="content">
        <div class="container-fluid">
	    	<div class="row" id="admin">
			 <div class="col-md-12">
				<div class="card card-default">
	                <div class="card-header text-center" style="background-color: #2FA3C6; color: white;">
	                    <h4 class="title">Subir Entregables</h4>  
	                </div>
	                <div class="card-body">
	                    <form @submit.prevent="registrar" >
	                        <div class="row">
	                            <div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Oficina</label>
										<select v-model="subactividad.oficina" class="form-control" @change="objetivos()">
											<option v-for="o in oficinas" :key="o.IDOficina" :value="o.IDOficina" >
												{{o.NombreOficina}}		
											</option>
										</select>
	                                </div>
	                            </div>
                                <div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Objetivo</label>
										<select v-model="subactividad.objetivo" class="form-control" @change="zprocesos()">
											<option v-for="z in objetivosL" :key="z.ID" :value="z.ID">
												{{z.Descripcion}}		
											</option>
										</select>
	                                </div>
	                            </div>
                                <div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Proceso Estratégico</label>
                                        <select v-model="subactividad.proceso" class="form-control" @change="zactividades()">
											<option v-for="o in procesosL" :key="o.ID" :value="o.ID">
												{{o.Descripcion}}		
											</option>
										</select>
                                    </div>
	                            </div>
                                <div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Actividad</label>
	                                	<select v-model="subactividad.actividad" class="form-control" @change="getSubActividad(subactividad.actividad)">
											<option v-for="o in actividadesL" :key="o.ID" :value="o.ID">
												{{o.Actividad}}		
											</option>
										</select>
									</div>
	                            </div>
							</div>
                            <div class="row">
                                <div class="col-md-12">
	                                <div class="form-group">
	                                    <label>Sub Actividad</label>
                                        <select v-model="subactividad.subactividad" @change="meta()" class="form-control">
                                            <option v-for="(s,index) of subactividades" :key="s.ID" :value="index+'-'+s.ID">{{s.SubActividad}}</option>
                                        </select>
	                                    <!-- <input type="text" v-model="subactividad.subactividad" readonly class="form-control"   maxlength="100"> -->
	                                </div>
	                            </div>

                                <div class="col-md-2">
	                                <div class="form-group">
	                                    <label>Meta</label>
	                                    <input type="text" v-model="subactividad.meta" readonly class="form-control"  min="0" max="100">
	                                </div>
	                            </div>
                                <div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Trimestre</label>
                                        <select class="form-control" v-model="subactividad.trimestre">
                                            <option value="1">I</option>
                                            <option value="2">II</option>
                                            <option value="3">III</option>
                                            <option value="4">IV</option>
                                        </select>
	                                </div>
	                            </div>
                                <div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Cantidad Realizada</label>
	                                    <input type="text" v-model="subactividad.monto" class="form-control"  min="0" max="100">
	                                </div>
	                            </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Nombre de Archivo</label>
                                        <input type="text" v-model="subactividad.nombre" class="form-control">        
                                    </div>
                                </div>
                            </div>
                            
							<div class="row">
                                <div class="col-md-4">
                                    <div class="dropbox">
                                    <input type="file" name="archivo"  class="input-file" @change="imageChanged">
                                        
                                    </div>
                                </div>
                            </div>
							<div class="row text-left">
								<div class="col-md-2">
									<input type="submit" value="Agregar" class="btn btn-success">
								</div>
							</div>
							<div class="clearfix"></div>
	                    </form>
                        
                        <hr>
	                </div>
				</div>
			</div>
	    	</div>
            <div class="row" id="oficina">
			 <div class="col-md-12">
				<div class="card card-default">
	                <div class="card-header text-center" style="background-color: #2FA3C6; color: white;">
	                    <h4 class="title">Subir Entregables</h4>  
	                </div>
	                <div class="card-body">
	                    <form @submit.prevent="registrar" >
	                        <div class="row">
                                <div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Objetivo</label>
										<select v-model="subactividad.objetivo" class="form-control" @change="zprocesos()">
											<option v-for="z in objetivosL" :key="z.ID" :value="z.ID">
												{{z.Descripcion}}		
											</option>
										</select>
	                                </div>
	                            </div>
                                <div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Proceso Estratégico</label>
                                        <select v-model="subactividad.proceso" class="form-control" @change="zactividades()">
											<option v-for="o in procesosL" :key="o.ID" :value="o.ID">
												{{o.Descripcion}}		
											</option>
										</select>
                                    </div>
	                            </div>
                                <div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Actividad</label>
	                                	<select v-model="subactividad.actividad" class="form-control" @change="getSubActividad(subactividad.actividad)">
											<option v-for="o in actividadesL" :key="o.ID" :value="o.ID">
												{{o.Actividad}}		
											</option>
										</select>
									</div>
	                            </div>
							</div>
                            <div class="row">
                                <div class="col-md-12">
	                                <div class="form-group">
	                                    <label>Sub Actividad</label>
                                        <select v-model="subactividad.subactividad" @change="meta()" class="form-control">
                                            <option v-for="(s,index) of subactividades" :key="s.ID" :value="index+'-'+s.ID">{{s.SubActividad}}</option>
                                        </select>
	                                    <!-- <input type="text" v-model="subactividad.subactividad" readonly class="form-control"   maxlength="100"> -->
	                                </div>
	                            </div>

                                <div class="col-md-2">
	                                <div class="form-group">
	                                    <label>Meta</label>
	                                    <input type="text" v-model="subactividad.meta" readonly class="form-control"  min="0" max="100">
	                                </div>
	                            </div>
                                <div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Trimestre</label>
                                        <select class="form-control" v-model="subactividad.trimestre">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
	                                </div>
	                            </div>
                                <div class="col-md-3">
	                                <div class="form-group">
	                                    <label>Cantidad Realizada</label>
	                                    <input type="text" v-model="subactividad.monto" class="form-control"  min="0" max="100">
	                                </div>
	                            </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Nombre de Archivo</label>
                                        <input type="text" v-model="subactividad.nombre" class="form-control">        
                                    </div>
                                </div>
                            </div>
                            
							<div class="row">
                                <div class="col-md-4">
                                    <div class="dropbox">
                                    <input type="file" name="archivo"  class="input-file" @change="imageChanged">
                                        
                                    </div>
                                </div>
                            </div>
							<div class="row text-left">
								<div class="col-md-2">
									<input type="submit" value="Agregar" class="btn btn-success">
								</div>
							</div>
							<div class="clearfix"></div>
	                    </form>
                        
                        <hr>
	                </div>
				</div>
			</div>
	    	</div>
	    </div>
	</div>
</template>
<script>
export default {
    data() {
      return {
        subactividad:{
            oficina:null,
            objetivo:null,
            proceso:null,
            actividad:null,
            subactividad:null,
            meta:null,
            unidad:null,
            responsable:null,
            ID:null,
            archivo:null,
            monto:null,
            trimestre:null,
            nombre:null,
        },
        clientes : [],
        oficinas:[],
        objetivosL:[],
        procesosL:[],
        encargado:[],
        actividadesL:[],
        subactividades:[]
      }
    },
    created() {
        this.getDatos();
        this.getActividades();
    },
    mounted(){
        $('#admin').hide();
        $('#oficina').hide();
        this.getTipo();
    },
    methods: {
        imageChanged(e){
            console.log(e.target.files[0])
            var fileReader = new FileReader()
            fileReader.readAsDataURL(e.target.files[0])    
            fileReader.onload = (e) =>{
                this.subactividad.archivo = e.target.result
            }
            console.log(this.subactividad)
        },
        registrar()
		{
            this.$Progress.start();
			axios.post("addEntregable",{
				subactividad:this.subactividad,
			}).then(data=>{
				console.log(data);
				swal({
                    position: 'top-end',
                    type: 'success',
                    title: 'Datos ingresados correctamente',
                    showConfirmButton: false,
                    timer: 2000
                });
                this.$Progress.finish();
                setTimeout(() => {
                    location.reload();
                }, 1500);
			}).catch(error=>{
				console.log(error);	
			})
        },
        getDatos()
        {
            axios.get("getOficinas")
            .then(data=>
            {
                this.oficinas = data.data.oficinas;
                console.log(this.oficinas);
            }
            ).catch(error=>{
                console.log(error);
            })
        },
        getTipo()
        {
            axios.get("getTipo")
            .then(data=>
            {
                console.log(data.data);
                // this.user.user = data.data.user;
                // this.user.pass = data.data.pass;
                if(data.data.tipo == 1)
                {
                    $("#admin").show();
                    $("#oficina").hide();
                }else{
                    $("#admin").hide();
                    $("#oficina").show();
                    this.subactividad.oficina = data.data.IDOficina;
                    this.objetivos(); 
                }
            }
            ).catch(error=>{
                console.log(error);
            })
        },
        getSubActividad(id){
            axios.get("getSubActividad/"+id)
            .then(data=>
            {
                this.subactividades             = data.data.subactividad;
                
                console.log(data.data);
            }
            ).catch(error=>{
                console.log(error);
            })
        },
        objetivos()
        {
			var id = this.subactividad.oficina;
            axios.get(`getObjetivos/${id}`)
            .then(data=>
            {
                this.objetivosL = data.data.objetivos;
                console.log(this.objetivosL);
            }
            ).catch(error=>{
                console.log(error);
            });
			axios.get(`getEncargados/${id}`)
            .then(data=>
            {
                this.encargado = data.data.encargados;
                console.log(data.data);
            }
            ).catch(error=>{
                console.log(error);
            })
        },
		zactividades()
        {
			var id = this.subactividad.proceso;
            axios.get(`getActividades/${id}`)
            .then(data=>
            {
                this.actividadesL = data.data.actividades;
                console.log(data.data);
            }
            ).catch(error=>{
                console.log(error);
            })
        },
        zprocesos()
        {
			var id2 = this.subactividad.objetivo;
			console.log(this.subactividad.objetivo);
			axios.get(`getProcesos/${id2}`)
            .then(data=>
            {
                this.procesosL = data.data.procesos;
                console.log(this.procesosL);
            }
            ).catch(error=>{
                console.log(error);
            })
		},
		getActividades()
        {
            axios.get(`getActividades`)
            .then(data=>
            {
                this.actividades = data.data.actividades;
                console.log(this.actividades);
            }
            ).catch(error=>{
                console.log(error);
            })
        },
        meta()
        {
            var id      = this.subactividad.subactividad;
            var guion   = id.search("-");
            var indice  = id.substr(0,guion);
            var sub     = id.substr(guion+1,id.length-guion);
            this.subactividad.meta  = this.subactividades[indice].Meta;
            this.subactividad.ID    = sub;
            
            console.log(this.subactividades,this.subactividades[indice].Meta);
        }
    },
  }
</script>
