ImagineCli
==========

Command line interface for [avalanche123/Imagine](https://github.com/avalanche123/Imagine) using the Symfony
[Console](https://github.com/symfony/Console) component. Mainly done to suit my own needs, so it may not have
the features you need, but feel free to fork and send pull requests.


##Installation

###Using composer (only way for now)

add this to your `composer.json`

```
require: {
    "imagine_cli/imagine_cli": "dev-master"
}
```

##Usage

### crop using all options

Crop source.png, starting at the pixel at x=20, y=20, and crop out a size 400 pixels wide and 300 pixels high and
save as destination.png

```
./imagine_cli crop source.png destination.png --cropx=20 --cropy=20 --cropwidth=400 --cropheight=300
```

### all options are optional

Cropping can be done with only a couple of parameters set. For example, this crop will remove a 20 pixels from
the left of the image

```
./imagine_cli crop source.png destination.png --cropx=20
```


## resize

Resize an image to 400 pixels wide, and 300 pixels high

```
./imagine_cli resize source.png destination.png --width=400 --height=300
```

## crop and resize

resize also takes the crop options so that the result of the crop will be resized. An example using all options:

```
./imagine_cli resize source.png destination.png --width=400 --height=300 --cropx=20 --cropy=20 --cropwidth=400 --cropheight=300
```

#More information

```
./imagine_cli help crop
```

and

```
./imagine_cli help resize
```

I will add more commands and/or options as I need them. Need more now? Fork! :-) WORK IN PROGRESS!
