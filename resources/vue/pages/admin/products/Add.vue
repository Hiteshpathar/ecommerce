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
                        <PDropZone
                            :openFileDialog="false"
                            :files="this.form.images??[]"
                            :validImageTypes='["image/gif","image/jpeg","image/png"]'
                            :handleOnDrop="handleOnDrop"
                            uploadedFiles
                            type="image"
                            :handleOnDropAccepted="handleOnDropAccepted"
                        />
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
                <PButton primary @click="createUpdateProduct">Save</PButton>
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
                categoryOption: [],
                form: {
                    _method: "POST",
                    id: null,
                    title: '',
                    description: '',
                    is_active: 1,
                    price: null,
                    inventory: 0,
                    category: null,
                    category_id: null,
                    images: [],
                },
                to: {name: "products"},
            }
        },
        async created() {
            if (this.$route.params.id) {
                this.pageTitle = "Edit Product";
                const response = await this.loadProduct(this.$route.params.id);
                this.form = {...response.data};
                this.form.images = [];
                if (response.data.category) {
                    this.form.category = {"name": response.data.category.name, "id": response.data.category.id};
                }
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

            handleOnDrop(files, accepted, rejected) {
                // this.files = accepted;
            },
            handleOnDropAccepted(files) {
                this.form.images = files;
            },
            getSelectedCategory(item) {
                this.form.category = item;
            },
            async createUpdateProduct() {
                if (this.form.id) {
                    this.form._method = "PUT";
                } else {
                    this.form._method = "POST";
                }
                if (this.form.category) {
                    this.form.category_id = this.form.category.id
                }
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
                    this.form.category_id = null;
                    this.form.price = 0;
                    this.images = [];
                    this.$router.push(this.to);
                }
            }
        }
    }
</script>

<style scoped>

</style>
