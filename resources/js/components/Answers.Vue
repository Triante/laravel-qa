<template>
    <div>    
        <div class="row mt-4" v-cloak v-if="count">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h2>{{title}}</h2>
                        </div>
                        <hr>
                        <answer @deleted="remove(index)" v-for="(answer, index) in answers" :answer="answer" :key="answer.id"></answer>
                        <div class="text-center mt-3" v-if="nextUrl">
                            <button class="btn btn-outline-secondary" @click="fetch(nextUrl)">Load More Answers</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <new-answer @created="add" :question-id="question.id"></new-answer>
    </div>
</template>

<script>
import Answer from './Answer';
import NewAnswer from './NewAnswer'
export default {
    props: ['question'],

    data() {
        return {
            questionId: this.question.id,
            count: this.question.answers_count,
            answers: [],
            nextUrl: null
        }
    },

    created () {
        this.fetch(`/questions/${this.questionId}/answers`);
    },

    methods : {
        remove(index) {
            this.answers.splice(index, 1);
            this.count--;
        },
        fetch(endpoint) {
            axios.get(endpoint)
            .then(({data}) => {
                console.log(data.data);
                this.answers.push(...data.data);
                this.nextUrl = data.next_page_url; 
            })
        },
        add(answer) {
            this.answers.push(answer);
            this.count++;
        }
    },

    computed: {
        title() {
            return this.count + " " + (this.count > 1 ? 'Answers' : 'Answer');
        }
    },
    components : {Answer, NewAnswer},
}
</script>

