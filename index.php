<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    </head>
    <body>
    <div id="app">
        <v-app>
        <v-main>
            <v-container>
                <v-data-table
                    :headers="headers"
                    :items="items"
                    class="elevation-1"
                >
                    <template v-slot:top>
                        <v-toolbar
                        flat
                        >
                        <v-toolbar-title>My To-do List</v-toolbar-title>
                        <v-divider
                            class="mx-4"
                            inset
                            vertical
                        ></v-divider>
                        <v-spacer></v-spacer>
                        <v-dialog
                            v-model="dialog"
                            max-width="500px"
                        >
                            <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                color="primary"
                                dark
                                class="mb-2"
                                v-bind="attrs"
                                v-on="on"
                            >
                                New To-do
                            </v-btn>
                            </template>
                            <v-card>
                            <v-card-title>
                                <span class="text-h5">{{ formTitle }}</span>
                            </v-card-title>
                
                            <v-card-text>
                                <v-container>
                                <v-row>
                                    <v-col
                                    cols="12"
                                    sm="6"
                                    md="4"
                                    >
                                    <v-text-field
                                        v-model="editedItem.name"
                                        label="To-Do"
                                    ></v-text-field>
                                    </v-col>
                                    <v-col
                                    cols="12"
                                    sm="6"
                                    md="4"
                                    >
                                    <v-text-field
                                        v-model="editedItem.created"
                                        label="Created At"
                                    ></v-text-field>
                                    </v-col>
                                    <v-col
                                    cols="12"
                                    sm="6"
                                    md="4"
                                    >
                                    <v-text-field
                                        v-model="editedItem.completed"
                                        label="Completed At"
                                    ></v-text-field>
                                    </v-col>
                                    <v-col
                                    cols="12"
                                    sm="6"
                                    md="4"
                                    >
                                    <v-text-field
                                        v-model="editedItem.status"
                                        label="Status"
                                    ></v-text-field>
                                    </v-col>
                                </v-row>
                                </v-container>
                            </v-card-text>
                
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                color="blue darken-1"
                                text
                                @click="close"
                                >
                                Cancel
                                </v-btn>
                                <v-btn
                                color="blue darken-1"
                                text
                                @click="save"
                                >
                                Save
                                </v-btn>
                            </v-card-actions>
                            </v-card>
                        </v-dialog>
                        <v-dialog v-model="dialogDelete" max-width="500px">
                            <v-card>
                            <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                                <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                                <v-spacer></v-spacer>
                            </v-card-actions>
                            </v-card>
                        </v-dialog>
                        </v-toolbar>
                    </template>
                    <template v-slot:item.actions="{ item }">
                        <v-icon
                        small
                        class="mr-2"
                        @click="editItem(item)"
                        >
                        mdi-pencil
                        </v-icon>
                        <v-icon
                        small
                        @click="deleteItem(item)"
                        >
                        mdi-delete
                        </v-icon>
                    </template>
                    <template v-slot:no-data>
                        <v-btn
                        color="primary"
                        @click="initialize"
                        >
                        Reset
                        </v-btn>
                    </template>
                </v-data-table>
            </v-container>
        </v-main>
        </v-app>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script>
        new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        dialog: false,
        dialogDelete: false,
        headers: [
            { text: 'Actions', value: 'actions', sortable: false },
            { text: 'Id', value: 'todoid' },
            { text: 'Name', value: 'name' },
            { text: 'Created At', value: 'created', sortable: true },
            { text: 'Completed At', value: 'carbs' },
            { text: 'Status', value: 'actions', sortable: false },
        ],
        desserts: [],
        editedIndex: -1,
        editedItem: {
            name: '',
            created: '',
            completed: '',
            status: '',
        },
        defaultItem: {
            name: '',
            created: '',
            completed: '',
            status: '',
        },
        }),

        computed: {
            formTitle () {
            return this.editedIndex === -1 ? 'New To-Do' : 'Edit To-Do'
            },
        },

        watch: {
            dialog (val) {
            val || this.close()
            },
            dialogDelete (val) {
            val || this.closeDelete()
            },
        },

        created () {
            this.initialize()
        },

        methods: {
            initialize () {

                editItem (item) {
                this.editedIndex = this.desserts.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialog = true
                },

                deleteItem (item) {
                this.editedIndex = this.desserts.indexOf(item)
                this.editedItem = Object.assign({}, item)
                this.dialogDelete = true
                },

                deleteItemConfirm () {
                this.desserts.splice(this.editedIndex, 1)
                this.closeDelete()
                },

                close () {
                this.dialog = false
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                })
                },

                closeDelete () {
                this.dialogDelete = false
                this.$nextTick(() => {
                    this.editedItem = Object.assign({}, this.defaultItem)
                    this.editedIndex = -1
                })
                },

                save () {
                if (this.editedIndex > -1) {
                    Object.assign(this.desserts[this.editedIndex], this.editedItem)
                } else {
                    this.desserts.push(this.editedItem)
                }
                this.close()
            }
        }
    });
    </script>
    </body>
</html>