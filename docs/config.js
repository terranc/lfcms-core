docute.init({
    debug: true,
    title: 'LFCMS template',
    twitter: 'terranc',
    repo: 'terranc/lfcms-template',
    tocVisibleDepth: 4,
    loading: {
        markdown: '# Loading...',
    },
    announcement: {
        type: 'success', // warning | danger | success | primary
        html: 'v0.0.1'
    },
    'edit-link': 'https://github.com/terranc/lfcms-template/edit/master/docs/',
    // plugins: [
    //     docsearch({
    //         apiKey: '你的 API Key',
    //         indexName: 'lfcms-template',
    //     })
    // ],
    // 这个插件同时需要你的 URL
    // 因为 docsearch 是按照你的线上 URL 抓取内容的
    // url: 'http://terran.cc/lfcms-template/'
})
