<template>
    <PPage v-if="this.pageCount>1">
        <PLayout>

            <PButton v-if="secondPaginationButton" @click="farPrevious" :disabled="farPreviousDisable"
                     :title="'Previous '+skipPage">

                <svg class="Polaris-Icon__Svg" focusable="false" aria-hidden="true" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M12 16a.997.997 0 0 1-.707-.293l-5-5a.999.999 0 0 1 0-1.414l5-5a.999.999 0 1 1 1.414 1.414L8.414 10l4.293 4.293A.999.999 0 0 1 12 16z"></path>
                </svg>

            </PButton>

            <PButton :disabled="previousDisable" @click="previousButton" title="Previous">
                <svg class="Polaris-Icon__Svg" focusable="false" aria-hidden="true" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M17 9H5.414l3.293-3.293a.999.999 0 1 0-1.414-1.414l-5 5a.999.999 0 0 0 0 1.414l5 5a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L5.414 11H17a1 1 0 1 0 0-2z"></path>
                </svg>
            </PButton>

            <PStackItem v-for="(page,index) in pages" :key="index">
                <PButtonGroup fullWidth spacing="loose">

                    <PButton v-if="page.breakView" tabindex="0">
                        <PTextStyle name="breakViewContent">{{ breakViewText }}</PTextStyle>
                    </PButton>
                    <PButton v-else-if="page.disabled" tabindex="0">{{ page.content}}</PButton>
                    <PButton v-else-if="page.content===selected" pressed tabindex="0">{{ page.content }}</PButton>

                    <PButton v-else @click="handlePageSelected(page.index + 1)"
                             @keyup.enter="handlePageSelected(page.index + 1)" tabindex="0">{{page.content }}
                    </PButton>
                </PButtonGroup>


            </PStackItem>

            <PButton :disabled="nextDisable" @click="nextButton" title="Next">
                <svg class="Polaris-Icon__Svg" focusable="false" aria-hidden="true" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="m17.707 9.293-5-5a.999.999 0 1 0-1.414 1.414L14.586 9H3a1 1 0 1 0 0 2h11.586l-3.293 3.293a.999.999 0 1 0 1.414 1.414l5-5a.999.999 0 0 0 0-1.414z"></path>
                </svg>
            </PButton>


            <PButton v-if="secondPaginationButton" @click="farNext" :disabled="farNextDisable"
                     :title="'Next '+skipPage">
                <svg class="Polaris-Icon__Svg" focusable="false" aria-hidden="true" viewBox="0 0 20 20"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M8 16a.999.999 0 0 1-.707-1.707L11.586 10 7.293 5.707a.999.999 0 1 1 1.414-1.414l5 5a.999.999 0 0 1 0 1.414l-5 5A.997.997 0 0 1 8 16z"></path>
                </svg>
            </PButton>
            <PTextStyle style="padding-top: 7px;width: 90px">&nbsp Go To Page &nbsp</PTextStyle>
            <PTextField v-model="selectedField" @input="userSelectedPage" style="width: 100px" type="number">
            </PTextField>
        </PLayout>
    </PPage>
</template>

<script>

    import _ from 'lodash';

    export default {
        props: {
            value: {
                type: Number
            },
            pageCount: {
                type: Number,
                required: true
            },
            forcePage: {
                type: Number
            },
            clickHandler: {
                type: Function,
                default: () => {
                }
            },
            pageRange: {
                type: Number,
                default: 3
            },
            marginPages: {
                type: Number,
                default: 1
            },
            breakViewText: {
                type: String,
                default: '…'
            },
            defaultPage: {
                type: Number,
                default: 0
            },
            total: {
                type: Number,
                default: 1
            },
            skipPage: {
                type: Number,
                default: 10
            },
            secondPaginationButton: {
                type: Boolean,
                default: true
            },
        },

        beforeUpdate() {
            if (this.forcePage === undefined) return
            if (this.forcePage !== this.selected) {
                this.selected = this.forcePage
            }
        },
        computed: {
            selected: {
                get: function () {
                    return this.value || this.innerValue
                },
                set: function (newValue) {
                    this.innerValue = newValue
                }
            },
            pages: function () {

                if (this.defaultPage === 1) {
                    this.handlePageSelected(1)
                }
                if (this.pageCount <= this.skipPage || this.skipPage<1) {
                    this.farNextDisable = true;
                }
                let items = {}
                if (this.pageCount <= this.pageRange) {
                    for (let index = 0; index < this.pageCount; index++) {
                        let page = {
                            index: index,
                            content: index + 1,
                            selected: index === (this.selected - 1)
                        }
                        items[index] = page
                    }
                } else {
                    const halfPageRange = Math.floor(this.pageRange / 2)
                    let setPageItem = index => {
                        let page = {
                            index: index,
                            content: index + 1,
                            selected: index === (this.selected - 1)
                        }
                        items[index] = page
                    }
                    let setBreakView = index => {
                        let breakView = {
                            disabled: true,
                            breakView: true
                        }
                        items[index] = breakView
                    }
                    // 1st - loop thru low end of margin pages
                    for (let i = 0; i < this.marginPages; i++) {
                        setPageItem(i);
                    }
                    // 2nd - loop thru selected range
                    let selectedRangeLow = 0;
                    if (this.selected - halfPageRange > 0) {
                        selectedRangeLow = this.selected - 1 - halfPageRange;
                    }
                    let selectedRangeHigh = selectedRangeLow + this.pageRange - 1;
                    if (selectedRangeHigh >= this.pageCount) {
                        selectedRangeHigh = this.pageCount - 1;
                        selectedRangeLow = selectedRangeHigh - this.pageRange + 1;
                    }
                    for (let i = selectedRangeLow; i <= selectedRangeHigh && i <= this.pageCount - 1; i++) {
                        setPageItem(i);
                    }
                    // Check if there is breakView in the left of selected range
                    if (selectedRangeLow > this.marginPages) {
                        setBreakView(selectedRangeLow - 1)
                    }
                    // Check if there is breakView in the right of selected range
                    if (selectedRangeHigh + 1 < this.pageCount - this.marginPages) {
                        setBreakView(selectedRangeHigh + 1)
                    }
                    // 3rd - loop thru high end of margin pages
                    for (let i = this.pageCount - 1; i >= this.pageCount - this.marginPages; i--) {
                        setPageItem(i);
                    }
                }
                return items
            }
        },
        data() {
            return {
                innerValue: 1,
                previousDisable: true,
                nextDisable: false,
                farPreviousDisable: true,
                farNextDisable: false,
                selectedField: 1
            }
        },
        methods: {
            nextButton() {
                this.handlePageSelected(this.selected + 1)
            },
            previousButton() {
                this.handlePageSelected(this.selected - 1)
            },
            farNext() {
                this.handlePageSelected(this.selected + this.skipPage)
            },
            farPrevious() {
                this.handlePageSelected(this.selected - this.skipPage)
            },
            userSelectedPage: _.debounce(function (val) {
                if (val===0){
                    return;
                }
                if (val < 1) {
                    this.handlePageSelected(1);
                } else if (val > this.pageCount) {
                    this.handlePageSelected(this.pageCount);
                } else {
                    this.handlePageSelected(val);
                }
            }, 1000),

            handlePageSelected(selected) {
                (selected > 1) ? this.previousDisable = false : this.previousDisable = true;
                (selected >= this.pageCount) ? this.nextDisable = true : this.nextDisable = false;

                if (this.pageCount > this.skipPage &&  this.skipPage>1) {
                    (selected > this.skipPage) ? this.farPreviousDisable = false : this.farPreviousDisable = true;
                    (selected > (this.pageCount - this.skipPage)) ? this.farNextDisable = true : this.farNextDisable = false;
                }
                this.selectedField=selected;
                if (this.selected === selected) return
                this.innerValue = selected
                this.$emit('input', selected)
                this.clickHandler(selected)
            },
        }
    }
</script>

<style lang="css" scoped>
    svg {
        height: 15px;
    }

</style>
