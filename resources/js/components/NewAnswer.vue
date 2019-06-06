<template>
    <div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h3>Your Answer</h3>
                </div>
                <hr>
                <form @submit.prevent="create">
                    <div class="form-group">
                        <m-editor :body ="body" name ="new-answer">
                            <textarea class="form-control" rows="7" name="body" required v-model="body"></textarea>
                        </m-editor>
                    </div> 
                    <div class="form-group">
                        <button type="submit" :disabled="isInvalid" class="btn btn-lg btn-outline-primary">Submit</button>
                    </div>
                </form> 
            </div>
        </div>
    </div>
</div>
</template>

<script>
import MEditor from './MEditor';
export default {
    props: ['questionId'],
    components: {MEditor},
    computed: {
        isInvalid() {
            return !this.signedIn || this.body.length < 1
        },
        endpoint() {
            return `/questions/${this.questionId}/answers`;
        }
    },
    methods: {
        create() {
            console.log(this.endpoint + "|" + this.body);
            axios.post(this.endpoint, {
                body: this.body
            })
            .then(res => {
                console.log(res);
                this.$toast.success(res.data.message, "Success");
                this.body = '';
                this.$emit('created', res.data.answer);
            }).catch(err=>{
                this.$toast.error(err.response.data.message, "Error");
            })
        }
    },
    data () {
        return {
            body: ""
        }
    },
}
</script>

