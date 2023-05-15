const mix = require("laravel-mix");

mix
  .sourceMaps()
  .webpackConfig({ devtool: "source-map" });
mix.webpackConfig({
  stats: {
    children: false,
  },
});
mix.sass("styles/main.scss", "styles/css");
