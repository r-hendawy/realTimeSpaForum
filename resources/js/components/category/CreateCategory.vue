<template>
	<v-container>
		<v-alert v-if="errors" type="error">
	      	Please fill out the field
	    </v-alert>

		<v-form @submit.prevent="submit">
			<v-row>

			    <v-col
			      cols="12"
			      md="12"
			    >
			      <v-text-field
			        v-model="form.name"
			        label="Category Name"
			        required
			      ></v-text-field>
			    </v-col>

			    <v-col
			      cols="12"
			      md="12"
			    >
					<v-btn type="submit" :disabled="disable" color="orange" tile large v-if="editSlug">Update</v-btn>

					<v-btn type="submit" :disabled="disable" color="success" tile large v-else>Create</v-btn>	
				</v-col>
			</v-row>
		</v-form>

		<v-card>
			<v-toolbar color="indigo" dark dense class="mt-2">
	      		<v-toolbar-title>Categories</v-toolbar-title>
	    	</v-toolbar>

			<v-list>
				<div 
					v-for="(category,index) in categories"
					:key="category.id"
					>
					<v-list-item @click="">
			    		<v-list-item-content>
				          <v-list-item-title>{{ category.name }}</v-list-item-title>
				        </v-list-item-content>

						<v-spacer></v-spacer>

						<v-btn icon>
				          <v-icon color="warning" @click="edit(index)">mdi-pencil</v-icon>
				        </v-btn>

						<v-btn icon @click="destroy(category.slug, index)">
				          <v-icon color="red">mdi-delete</v-icon>
				        </v-btn>
		    		</v-list-item>

		    		<v-divider></v-divider>
	    		</div>
	    	</v-list>
		</v-card>
	</v-container>	
</template>

<script>
	export default {
		data() {
			return {
				form: {
					name: null
				},
				categories: {},
				errors: null,
				editSlug: null
			}
		},
		created() {
			if (!User.admin()) {
				this.$router.push('/forum')
			}

			axios.get('/api/category')
				.then(res => this.categories = res.data.data)
		},
		computed: {
			disable() {
				//return !this.form.name
			}
		},
		methods: {
			submit() {
				this.editSlug ? this.update() : this.create()
			},
			create() {
				axios.post('/api/category', this.form)
					.then(res => {
						this.categories.unshift(res.data)
						this.form.name = null
					})
					.catch(err => {
						this.errors = err.response.data.errors
					})
			},
			update() {
				axios.patch(`/api/category/${this.editSlug}`, this.form)
					.then(res => {
						this.categories.unshift(res.data)
						this.editSlug  = null
						this.form.name = null
					})			
			},
			destroy(slug, index) {
				axios.delete(`/api/category/${slug}`)
					.then(res => {
						this.categories.splice(index,1)
					})
			},
			edit(index) {
				this.form.name = this.categories[index].name
				this.editSlug = this.categories[index].slug
				this.categories.splice(index,1)
			}
		}
	}
</script>