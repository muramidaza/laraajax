/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');
	
window.Vue = require('vue');
import VueRouter from 'vue-router';
	
window.Vue.use(VueRouter);

import Vuelidate from 'vuelidate';
Vue.use(Vuelidate);

import Adminka from './components/adminka.vue';

import CompaniesIndex from './components/companies/CompaniesIndex.vue';
import CompaniesCreate from './components/companies/CompaniesCreate.vue';
import CompaniesEdit from './components/companies/CompaniesEdit.vue';
import CompaniesShow from './components/companies/CompaniesShow.vue';

import DepartmentsIndex from './components/departments/DepartmentsIndex.vue';
import DepartmentsCreate from './components/departments/DepartmentsCreate.vue';
import DepartmentsEdit from './components/departments/DepartmentsEdit.vue';
import DepartmentsShow from './components/departments/DepartmentsShow.vue';

import PeopleIndex from './components/people/PeopleIndex.vue';
import PeopleCreate from './components/people/PeopleCreate.vue';
import PeopleEdit from './components/people/PeopleEdit.vue';
	
const routes = [
	{path: '/', component: Adminka, name: 'Adminka'},
	
	{path: '/admin/companies/index', component: CompaniesIndex, name: 'indexCompany'},
	{path: '/admin/companies/create', component: CompaniesCreate, name: 'createCompany'},
	{path: '/admin/companies/edit/:id', component: CompaniesEdit, name: 'editCompany'},
	{path: '/admin/companies/show/:id', component: CompaniesShow, name: 'showCompany'},
	
	{path: '/admin/departments/index', component: DepartmentsIndex, name: 'indexDepartment'},
	{path: '/admin/departments/create', component: DepartmentsCreate, name: 'createDepartment'},
	{path: '/admin/departments/edit/:id', component: DepartmentsEdit, name: 'editDepartment'},
	{path: '/admin/departments/show/:id', component: DepartmentsShow, name: 'showDepartment'},
	
	{path: '/admin/people/index', component: PeopleIndex, name: 'indexPeople'},
	{path: '/admin/people/create', component: PeopleCreate, name: 'createPeople'},
	{path: '/admin/people/edit/:id', component: PeopleEdit, name: 'editPeople'},		
]
	
const router = new VueRouter({ routes });
	
const app = new Vue({ router }).$mount('#app');
