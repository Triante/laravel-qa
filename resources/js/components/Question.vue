<template>
        <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body" v-if="!editing">
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h1>{{title}}</h1>
                            <div class="ml-auto">
                                <a href="/questions" class="btn btn-outline-secondary">Back to All Questions</a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="media">
                        <vote :model="question" name="question"></vote>
                        <div class="media-body">
                            <div v-html="bodyHtml"></div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="ml-auto">
                                        <a v-if="authorize('modify', question)" @click.prevent="edit" class="btn btn-sm btn-outline-info">Edit</a>
                                        <button v-if="authorize('deleteQuestion', question)" @click="destroy" class="btn btn-sm btn-outline-danger">delete</button>
                                    </div>
                                </div>
                                <div class="col-4"></div>
                                <div class="col-4">
                                    <user-info v-bind:model="question" label="Asked"></user-info>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="card-body" v-else @submit.prevent="update">
                    <div class="card-title">
                       <input type="text" class="form-control form-control-lg" v-model="title" required>
                    </div>
                    <hr>
                    <div class="media">
                        <div class="media-body">
                            <div class="form-group">
                                <m-editor :body="body">
                                    <textarea rows ="10" v-model="body" class="form-control" required></textarea>
                                </m-editor>
                            </div>
                            <button class="btn btn-primary" :disabled="isInvalid">Update</button>
                            <button class="btn btn-outline-secondary" @click="cancel" type="button">Cancel</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</template>

<script>
import Vote from './Vote';
import UserInfo from './UserInfo';
import MEditor from './MEditor';
import modification from '../mixins/modification';


import { setTimeout } from 'timers';
export default {
    props: ['question'],
    mixins: [modification],
    components: {Vote, UserInfo, MEditor},
    data () {
        return {
            title: this.question.title,
            body: this.question.body,
            bodyHtml: this.question.body_html,
            id: this.question.id,
            beforeEditCache: {},
        }
    },
    computed: {
        isInvalid () {
            return this.body.length < 1 || this.title.length < 1;
        },
        endpoint() {
            return `/questions/${this.id}`;
        },
    },
    methods: {
        setEditCache() {
            this.beforeEditCache = {
                body: this.body,
                title: this.title
            };
        },
        restoreFromCache() {
            this.body = this.beforeEditCache.body;
            this.title = this.beforeEditCache.title;
        },
        payload() {
            return {
                body: this.body, title: this.title
            };
        },
         delete() {
             axios.delete(this.endpoint)
            .then(res=> {
                this.$toast.success(res.data.message, "Success", {timeout: 2000})
            })
            .catch(err => {
                console.log(err);
            });

            setTimeout(() => {
                window.location.href = "/questions";
            }, 3000);
        }
    }
}
</script>

