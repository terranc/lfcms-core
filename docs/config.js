docute.init({
    debug: true,
    twitter: 'terranc',
    repo: 'terranc/lfcms-template',
    loading: {
        markdown: '# Loading...',
    },
    'edit-link': 'https://github.com/terranc/lfcms-template/blob/master/docs/',
    plugins: [
        docsearch({
            apiKey: '你的 API Key',
            indexName: '你的 Index Name',
            // docsearch 允许你把抓取的内容按照 tag 分类
            // 详情请联系 algolia 客服，这里你只需要把你想搜索的 tag 填进来就行了
            tags: ['english', 'zh-Hans', 'zh-Hant']
        })
    ],
    // 这个插件同时需要你的 URL
    // 因为 docsearch 是按照你的线上 URL 抓取内容的
    url: 'https://terranc.github.io/lfcms-template'
})
