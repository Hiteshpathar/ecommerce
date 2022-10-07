<template>
    <PPage :title="pageTitle"
           :breadcrumbs='[{"content":"Users","to":to}]'
    >
        <PLayout>
            <PLayoutSection>
                <PCard sectioned="" :actions="[]">
                    <PFormLayout>
                        <PTextField label="Title" placeholder="Realme C11" v-model="form.title"
                                    :error="errors.title ? errors.title[0] : ''" id="title"/>
                        <PTextField
                            label="Description"
                            v-model="form.description"
                            placeholder="Product Info"
                        />
                    </PFormLayout>
                </PCard>
                <PCard>
                    <PCardHeader
                        title="Product Images"
                        :actions='[{"content":"Upload Image"}]'
                    />
                    <PCardSection>
                        <PStackItem>
                            <PTextStyle variation="strong">You can upload only one file.</PTextStyle>
                            <br>
                            <input type="file" id="file" name="file" accept="image/*" @change="onSelectFile($event)">
                            <PInlineError v-if="errors.file" :message="errors.file[0]" fieldID="file"/>
                        </PStackItem>
                        <PStackItem>
                            <PImage :source="form.image_preview" v-if="form.image_preview" height="100"
                                    width="100" @click.native="fullImage"/>
                        </PStackItem>
                        <PStackItem fill="">
                            <PButton title="Remove" v-if="form.image_preview" plain @click="removeImage">
                                <!--<PIcon source="MobileCancelMajorMonotone" color="red"/>-->
                                <PIcon source="MobileCancelMajor" color="critical"/>
                            </PButton>
                        </PStackItem>
                    </PCardSection>

                </PCard>
                <PCard sectioned="" :actions="[]" title="Pricing">
                    <PFormLayout>
                        <PTextField label="Price" placeholder="0.00" prefix="₹" v-model="form.price"
                                    :error="errors.price ? errors.price[0] : ''"/>
                        <PTextField label="Compare at price" prefix="₹" placeholder="₹ 0.00"/>
                        <PTextField label="Cost per item" prefix="₹" placeholder="₹ 0.00"/>
                        <PTextField label="Quantity" type="number" value="0" v-model="form.inventory"/>
                    </PFormLayout>
                </PCard>
            </PLayoutSection>
            <PLayoutSection secondary="">
                <PCard title="Product Status" sectioned="" :actions="[]">
                    <PFormLayout>
                        <PSelect
                            :options='[
                                {label:"Active",value:1},
                                {label:"Draft",value:0}
                            ]'
                            v-model="form.is_active"
                        />
                        <template>
                            <PMultiSelect
                                :options=categoryOption
                                placeholder="Category"
                                @change="getSelectedCategory"
                                :multiple="false"
                                textField="name"
                                valueField="id"
                                :value="form.category"

                            />
                        </template>
                    </PFormLayout>
                </PCard>
            </PLayoutSection>
            <PLayoutSection>
                <PButton primary @click="createProduct">Save</PButton>
            </PLayoutSection>
        </PLayout>
    </PPage>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import _ from 'lodash';

    export default {
        name: "Products",
        data() {
            return {
                pageTitle: "Add Product",
                product: {},
                popup: false,
                categoryOption: [
                    // {"label":"Vue.js","language":"vue.js"},
                    // {"label":"Rails","language":"rails"},
                    // {"label":"Laravel","language":"laravel","hidden":true},
                ],
                form: {
                    _method: "POST",
                    id: null,
                    title: '',
                    description: '',
                    is_active: 1,
                    price: null,
                    inventory: 0,
                    category: null,
                    image_preview: '',
                    is_remove_image: 0
                },
                importForm: {
                    file: '',
                    email: ''
                },
                files: [],
                to: {name: "products"},
            }
        },
        async created() {
            if (this.$route.params.id) {
                this.pageTitle = "Edit Product";
                const response = await this.loadProduct(this.$route.params.id);
                this.form = {...response.data};
                this.form.category = {"name": response.data.category.name, "id": response.data.category.id};
            }
            let {data} = await this.getCategories();
            this.categoryOption = data;
        },
        computed: {
            ...mapGetters('products', {
                errors: 'getErrors',
                message: 'getMessage'
            }),
        },
        methods: {
            ...mapActions('products', [
                'loadProduct',
                'getCategories',
                'productCreateUpdate',
                'resetError',
            ]),

            onSelectFile: function (e) {

                const file = e.target.files[0];
                if (!e.target.files.length)
                    return;
                this.importForm.file = file;

                this.form.image_preview = URL.createObjectURL(file);
                this.form.is_remove_image = 0;
            },
            removeImage() {
                this.form.image_preview = "";
                this.form.is_remove_image = 1;
                if (this.isEdit == false) {
                    this.form.file = '';
                    document.getElementById('file').value = "";
                }
            },
            getSelectedCategory(item) {
                this.form.category = item;
            },
            async createProduct() {
                await this.productCreateUpdate(this.form);
                if (this.errors.length === 0) {
                    this.$pToast.open({
                        message: this.message
                    });
                    this.form.title = '';
                    this.form.description = '';
                    this.form.is_active = 1;
                    this.form.inventory = 0;
                    this.form.category = null;
                    this.form.price = 0;
                    this.$router.push(this.to);
                }
            }
        }
    }
</script>

<style scoped>

</style>
