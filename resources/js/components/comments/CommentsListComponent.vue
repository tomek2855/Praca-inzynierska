<template>
    <div>
        <h4>Komentarze</h4>
        <span v-if="comments.length < 1">Brak komentarzy</span>
        <div v-for="comment in comments" class="card">
            <div class="card-header">
                foto
                {{ comment.user.name }}
                <span v-show="comment.updated_at" class="small"> - {{ comment.updated_at }}</span>
                <div class="inline">
                    <button @click="deleteComment(comment)" class="btn btn-sm btn-danger float-right">Usuń</button>
                    <button @click="editComment(comment, false)" v-show="commentEditId != comment.id" class="btn btn-sm btn-primary float-right" style="margin-right: 5px">Edytuj</button>
                    <button @click="editComment(comment, true)" v-show="commentEditId == comment.id" class="btn btn-sm btn-success float-right" style="margin-right: 5px">Zapisz</button>
                    <a v-if="comment.file" v-bind:href="fileUrl(comment.file.id)" @click.prevent="service.downloadFile(comment.file.id)" class="float-right" style="margin-right: 10px"><small>{{ comment.file.original_filename }}</small></a>
                </div>
            </div>
            <div class="card-body">
                <div v-show="commentEditId != comment.id">
                    {{ comment.content }}
                </div>
                <div v-show="commentEditId == comment.id" class="form-group">
                    <textarea v-model="comment.content" class="form-control"></textarea>
                </div>
            </div>
        </div>

        <hr>

        <div class="form-group">
            <label for="comment">Dodaj komentarz</label>
            <textarea v-model="commentContent" id="comment" class="form-control" cols="30" rows="5"></textarea>
        </div>
        <div class="row">
            <div class="col-8">
                <div class="form-group">
                    <label for="comment-file">Wybierz plik</label>
                    <input v-on:change="handleFileUpload()" ref="commentFile" type="file" id="comment-file" class="form-control-file">
                </div>
            </div>
            <div class="col-4">
                <div class="btn-group-vertical float-right">
                    <button v-on:click="addComment" class="btn btn-success float-right">Dodaj komentarz</button>
                </div>
            </div>
        </div>

        <span v-if="error" class="error">{{ error }}</span>
    </div>
</template>

<script>
    export default {
        name: "comments-list-component",
        props: ["service"],
        data() {
            return {
                error: "",
                comments: [],
                commentContent: "",
                commentFile: null,
                commentFileId: null,
                commentEditId: null,
            }
        },
        mounted() {
            this.getComments()
        },
        methods: {
            getComments() {
                let loader = this.$loading.show()

                this.service.getIssueComments(this.$route.params.id).then(response => {
                    this.comments = response.data
                }).catch(error => {
                    this.error = error
                }).finally(() => {
                    loader.hide()
                })
            },
            addComment() {
                let loader = this.$loading.show()

                this.service.addIssueComment(this.$route.params.id, {
                    content: this.commentContent,
                    file_id: this.commentFileId
                }).then(response => {
                    this.commentContent = ""
                    this.commentFileId = null
                    this.commentFile = null
                    this.error = ""
                    this.$refs.commentFile.value = null
                    this.getComments()
                }).catch(error => {
                    this.error = ""

                    if (error.response.data.errors.content.length > 0) {
                        error.response.data.errors.content.forEach(item => {
                            this.error += item
                        })
                    }
                    if (error.response.data.errors.file_id.length > 0) {
                        error.response.data.errors.file_id.forEach(item => {
                            this.error += item
                        })
                    }

                    this.getComments()
                }).finally(() => {
                    loader.hide()
                })
            },
            deleteComment(comment) {
                this.$dialog
                    .confirm('Na pewno usunąć komentarz?', {okText: "Tak", cancelText: "Nie"})
                    .then(() => {
                        let loader = this.$loading.show()

                        this.service.delete(comment).then(response => {
                            this.getComments()
                        }).catch(error => {
                            this.error = error
                            this.getComments()
                        }).finally(() => {
                            loader.hide()
                        })
                })
            },
            editComment(comment, save) {
                if (save) {
                    let loader = this.$loading.show()

                    this.commentEditId = null

                    this.service.save(comment).then(response => {
                        comment.updated_at = response.data.updated_at
                    }).catch(error => {
                        this.error = error
                        this.getComments()
                    }).finally(() => {
                        loader.hide()
                    })
                } else {
                    this.commentEditId = comment.id
                }
            },
            handleFileUpload() {
                let loader = this.$loading.show()

                this.commentFile = this.$refs.commentFile.files[0]

                if (this.$refs.commentFile.files.length < 1) {
                    this.error = ""
                    loader.hide()
                    return null
                }

                this.service.uploadFile(this.commentFile, {isPublic: false}).then(response => {
                    this.commentFileId = response.data.id
                    this.error = ""
                }).catch(error => {
                    this.error = error
                    this.commentFileId = null
                }).finally(() => {
                    loader.hide()
                })
            },
            fileUrl(id) {
                return "/files/" + id
            }
        }
    }
</script>

<style scoped>
    .inline {
        display: inline;
    }
    .card {
        margin-bottom: 10px;
    }
    .card-body {
        padding: 0.75rem;
    }
</style>