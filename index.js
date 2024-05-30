const title = document.querySelector('.title')
const sky = document.querySelector('.sky')
const mount1 = document.querySelector('.mount1')
const mount2 = document.querySelector('.mount2')

document.addEventListener('scroll', function() {

    let value = window.scrollY
    title.style.marginTop = value + 'px'

    sky.style.marginBottom = -value + 'px'
    mount1.style.marginBottom = -value * 1.1 + 'px'
    mount2.style.marginBottom = -value * 1.2 + 'px'

}
)