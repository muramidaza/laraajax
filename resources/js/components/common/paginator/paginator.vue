<template>
	<nav>
		<ul class="pagination justify-content-center" v-if="countPages > 0">
			<li class="page-item">
				<button class="page-link" @click="paginatorPage--" v-if="paginatorPage > 0">Previous</button>
			</li>
			<li class="page-item" v-for="number in paginatorButtons[paginatorPage]" v-bind:class="{active: currentPage == number}">
				<button class="page-link" @click="currentPage = number; $emit('onChangePage', number)">
					{{ number }} <span v-if="number == currentPage" class="sr-only">(current)</span>
				</button>
			</li>
			<li class="page-item">
				<button class="page-link" @click="paginatorPage++" v-if="paginatorPage < paginatorButtons.length - 1">Next</button>
			</li>
		</ul>
	</nav>
</template>

<script>
	//countPages > 0 в самом начале темплейта нужен	чтобы vue перерисовал темплейт пагинатора - без этого, почему то, не перерисовывает
	
	const RECORDS_IN_PAGE = 5;
	const PAGINATOR_LENGTH = 5;

	export default {
		name: 'paginator',
		props: ['countRecords', 'recordsInPage'],   
		data() {
			return {
				paginatorButtons: [], 
				currentPage: 1,
				paginatorPage: 0,
				countPages: 0
           }
        },
        mounted() {
			const app = this;
			const recordsInPage = app.recordsInPage ? app.recordsInPage : RECORD_IN_PAGE;

			app.countPages = Math.ceil(app.countRecords / recordsInPage);
			console.log(app.countRecords);
			console.log(recordsInPage);
			console.log(app.countPages);
			let pageNum = 1;
			for(let i = 0; pageNum <= app.countPages; i++) {
				app.paginatorButtons[i] = [];
				for(let j = 0; j < PAGINATOR_LENGTH && pageNum <= app.countPages; j++, pageNum++) {
					app.paginatorButtons[i].push(pageNum);
				}
			}
			console.log(app);
        }  
    }
</script>  