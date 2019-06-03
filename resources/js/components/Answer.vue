<script>
export default {
    props: ['answer'],

    data() {
        return {
            editing: false,
            body: this.answer.body,
            bodyHtml: this.answer.body_html,
            id: this.answer.id,
            questionId: this.answer.question_id,
            beforeEditCache: null
        }
    },

    methods: {
        edit() {
            this.beforeEditCache = this.body;
            this.editing = true;
        },

        cancel() {
            this.body = this.beforeEditCache;
            this.editing = false;
        },

        update() {
            axios.patch(this.endpoint, {
                body: this.body
            })
            .then(res => {
                console.log(res.data.message);
                this.$toast.success(res.data.message, "Success", {timeout: 3000});
                this.editing = false;
                this.bodyHtml = res.data.body_html
            })
            .catch(err => {
                this.$toast.success(err.data.message, "Error", {timeout: 3000});
                console.log("Something went wrong: " + err);
            });
        },

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
        
                    axios.delete(this.endpoint)
                    .then(res=> {
                        $(this.$el).fadeOut(500, ()=> {
                            this.$toast.success(res.data.message, "Success", {timeout: 3000});
                        })
                    })
                    .catch(err => {
                        console.log(err);
                    });
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        
                }, true],
                ['<button>No</button>', function (instance, toast) {
        
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
        
                }],
            ],
        });
        }
    }, 
    
    computed: {
            isInvalid () {
                return this.body.length < 1;
            },

            endpoint() {
                return `/questions/${this.questionId}/answers/${this.id}`;
            }
        }
}
</script>
