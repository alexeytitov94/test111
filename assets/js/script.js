new Vue({
	el: '#product',
    created() {
        this.fetchData()
    },
	data: {
		products: [],
		sizeAll: {
            start: 0,
			next: 50
		},
		cart: [],
		isActiveCard: false,
		search_product: '',
        loader: false
	},
	methods: {
        handleScroll() {
        	let heightTable = $('.product_container').outerHeight(true),
                scrollBottom = $(window).scrollTop() + $(window).height() + 100;

        	if (scrollBottom >= heightTable && this.loader == false) {
        		this.loader = true;
                this.sizeAll.start += 50;
                this.sizeAll.next += 50;

                this.fetchData();
			}
        },
        fetchData() {
            const data = new FormData();
            data.append('start', this.sizeAll.start);
            data.append('next', this.sizeAll.next);

            axios.post('api/getData.php', data).then(response => {
            	this.products = this.products.concat(response.data);
            	this.loader = false;
			})
			.catch(e => {
				console.log(e);
			})
		},
		addToCart(product, index) {

			if ( this.cart.indexOf( product ) == -1 ) 
			{
				this.cart.push(product);
				$('#checkbox_' + index).prop('checked', true);
			} else {
				this.cart.splice(this.cart.indexOf( product ), 1);
                $('#checkbox_' + index).prop('checked', false);
			}


			if (this.cart.length == 0) 
			{
				this.isActiveCard = false;

			} else {
				if (this.isActiveCard == false) 
				{
					this.isActiveCard = true;
				}
			}
		},
	    searchProduct: _.debounce(
	    	function() {

                this.products = '';
                this.loader = true;

                const data = new FormData();
                data.append('search', this.search_product.toUpperCase());
                data.append('start', 0);
                data.append('next', 50);


				axios.post('api/search.php', data).then(response => {
                    this.products = response.data
					this.sizeAll.start = 0;
					this.sizeAll.next = 0;

                	this.loader = false;
				})
				.catch(e => {
					console.log(e);
				})
    	}, 5000),
	},
    beforeMount () {
        window.addEventListener('scroll', this.handleScroll);
    },
    beforeDestroy () {
        window.removeEventListener('scroll', this.handleScroll);
    }
})