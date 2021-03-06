export default {
    data() {
        return {
            editing: false,
        }
    },
    methods: {
        edit() {
            this.setEditCache();
            this.editing = true;
        },
        cancel() {
            this.restoreFromCache();
            this.editing = false;
        },
        setEditCache() {},
        restoreFromCache() {},
        update() {
            axios.put(this.endpoint, this.payload())
            .then(res=> {
                this.$toast.success(res.data.message, "Success", {timeout: 3000});
                this.bodyHtml = res.data.body_html;
                this.title = res.data.title;
                this.editing = false;
            })
            .catch(err => {
                this.$toast.error(err.response.data.message, "Error", {timeout: 3000});
            })
        },
        payload() {},
        destroy() {
            this.$toast.question('Are you sure about that?', 'Hey', {
            timeout: 20000,
            close: false,
            overlay: true,
            displayMode: 'once',
            id: 'question',
            zindex: 999,
            position: 'center',
            buttons: [
                ['<button><b>Yes</b></button>', (instance, toast) => {
        
                    this.delete();

                    setTimeout(() => {
                        window.location.href = "/questions";
                    }, 3000)

                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        
                }, true],
                ['<button>No</button>', function (instance, toast) {
        
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        
                }],
            ],
        });
        },
        delete() {},
    }
}