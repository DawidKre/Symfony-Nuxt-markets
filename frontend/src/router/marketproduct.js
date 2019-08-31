import MarketProductList from '../components/marketproduct/List'
import MarketProductCreate from '../components/marketproduct/Create'
import MarketProductUpdate from '../components/marketproduct/Update'
import MarketProductShow from '../components/marketproduct/Show'

export default [
  { name: 'MarketProductList', path: '/api/market_products/', component: MarketProductList },
  { name: 'MarketProductCreate', path: '/api/market_products/create', component: MarketProductCreate },
  { name: 'MarketProductUpdate', path: '/api/market_products/edit/:id', component: MarketProductUpdate },
  { name: 'MarketProductShow', path: '/api/market_products/show/:id', component: MarketProductShow }
]
