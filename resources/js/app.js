/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

window.IDCompanyForDepartment = -1;
window.referTypeForPersons = 'none';
window.referIDForPersons = -1;
window.referTypeForEquipments = 'none';
window.referIDForEquipments = -1;
window.referTypeForActs = 'none';
window.referIDForActs = -1;
window.filter = 'all';
	
window.Vue = require('vue');
import VueRouter from 'vue-router';
	
window.Vue.use(VueRouter);

import Vuelidate from 'vuelidate';
Vue.use(Vuelidate);

import Adminka from './components/adminka.vue';

import CompaniesIndex from './components/companies/CompaniesIndex.vue';
import CompanyCreate from './components/companies/CompanyCreate.vue';
import CompanyEdit from './components/companies/CompanyEdit.vue';
import CompanyShow from './components/companies/CompanyShow.vue';

import DepartmentsIndex from './components/departments/DepartmentsIndex.vue';
import DepartmentCreate from './components/departments/DepartmentCreate.vue';
import DepartmentEdit from './components/departments/DepartmentEdit.vue';
import DepartmentShow from './components/departments/DepartmentShow.vue';

import PersonsIndex from './components/persons/PersonsIndex.vue';
import PersonCreate from './components/persons/PersonCreate.vue';
import PersonEdit from './components/persons/PersonEdit.vue';
import PersonShow from './components/persons/PersonShow.vue';

import EquipmentsIndex from './components/equipments/EquipmentsIndex.vue';
import EquipmentCreate from './components/equipments/EquipmentCreate.vue';
import EquipmentEdit from './components/equipments/EquipmentEdit.vue';
import EquipmentShow from './components/equipments/EquipmentShow.vue';

import UsersIndex from './components/users/UsersIndex.vue';
import UserEdit from './components/users/UserEdit.vue';
import UserShow from './components/users/UserShow.vue';

import ActsIndex from './components/acts/ActsIndex.vue';
import ActCreate from './components/acts/ActCreate.vue';
import ActEdit from './components/acts/ActEdit.vue';
import ActShow from './components/acts/ActShow.vue';
import ActWork from './components/acts/ActWork.vue';

import SparesIndex from './components/spares/SparesIndex.vue';
import SpareEdit from './components/spares/SpareEdit.vue';
	
const routes = [

	{path: '/', component: Adminka, name: 'Adminka'},
	
	{path: '/admin/companies/index', component: CompaniesIndex, name: 'indexCompanies'},
	{path: '/admin/companies/create', component: CompanyCreate, name: 'createCompany'},
	{path: '/admin/companies/edit/:id', component: CompanyEdit, name: 'editCompany'},
	{path: '/admin/companies/show/:id', component: CompanyShow, name: 'showCompany'},
	
	{path: '/admin/departments/index', component: DepartmentsIndex, name: 'indexDepartments'},
	{path: '/admin/departments/create', component: DepartmentCreate, name: 'createDepartment'},
	{path: '/admin/departments/edit/:id', component: DepartmentEdit, name: 'editDepartment'},
	{path: '/admin/departments/show/:id', component: DepartmentShow, name: 'showDepartment'},
	
	{path: '/admin/persons/index', component: PersonsIndex, name: 'indexPersons'},
	{path: '/admin/persons/create', component: PersonCreate, name: 'createPerson'},
	{path: '/admin/persons/edit/:id', component: PersonEdit, name: 'editPerson'},
	{path: '/admin/persons/show/:id', component: PersonShow, name: 'showPerson'},
	
	{path: '/admin/equipments/index', component: EquipmentsIndex, name: 'indexEquipments'},
	{path: '/admin/equipments/create', component: EquipmentCreate, name: 'createEquipment'},
	{path: '/admin/equipments/edit/:id', component: EquipmentEdit, name: 'editEquipment'},
	{path: '/admin/equipments/show/:id', component: EquipmentShow, name: 'showEquipment'},
	
	{path: '/admin/acts/index', component: ActsIndex, name: 'indexActs'},
	{path: '/admin/acts/create', component: ActCreate, name: 'createAct'},
	{path: '/admin/acts/edit/:id', component: ActEdit, name: 'editAct'},
	{path: '/admin/acts/show/:id', component: ActShow, name: 'showAct'},
	{path: '/admin/acts/work/:id', component: ActWork, name: 'workAct'},
	
	{path: '/admin/users/index', component: UsersIndex, name: 'indexUsers'},
	{path: '/admin/users/edit/:id', component: UserEdit, name: 'editUser'},
	{path: '/admin/users/show/:id', component: UserShow, name: 'showUser'},

	{path: '/admin/spares/index', component: SparesIndex, name: 'indexSpares'},
	{path: '/admin/spare/edit', component: SpareEdit, name: 'editSpare'},
	
]
	
const router = new VueRouter({ routes });
	
const app = new Vue({ router }).$mount('#app');
