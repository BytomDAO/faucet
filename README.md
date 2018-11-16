Faucet
=======

Bytom testnet faucet implemented by PHP.

## 1 Install Apache

Install Apache：

```
$ yum -y install httpd
```

Start Apache:

```
$ systemctl start httpd.service
```

Set startup:

```
$ systemctl enable httpd.service
```

## 2 Install PHP

Install PHP:

```
$ yum -y install php
```

Edit `/etc/php.ini`, set `short_open_tag = ON`:

```
short_open_tag = ON
```

Restart Apache:

```
$ systemctl restart httpd.service
```

## 3 Install bytom from source

Firtly, you should install [go](https://golang.org/doc/install) and set correct GOPATH and PATH.

Get the source code:

```
$ git clone https://github.com/Bytom/bytom.git $GOPATH/src/github.com/bytom
```

Build source code:

```
$ cd $GOPATH/src/github.com/bytom
$ make install
```

## 4 Initial and launch bytom node

Initial:

```
$ bytomd init --chain_id testnet
```

Launch:

```
$ nohup bytomd node >> log.out &
```

Create key:

```
$ bytomcli create-key key_1 12345
```

Create account:

```
$ bytomcli create-account account_1 <xpubs-from-create-key>
```

Create address:

```
$ bytomcli create-account-receiver account_1
```

## 5 Install frontend

```
$ cd /var/www/html/
$ git clone https://github.com/bytom/faucet.git
```

## 6 Get testnet btm

You can get testnet btm using `--mining` when you launch bytom. You can also contact us to get some testnet btm using issues.

## 7 Specification

Don't forget change some accounts and addresses in the code. Your account and address should replace mine. Any issues you can report in the repository.

## 8 Example

- [Bytom testnet faucet](http://test.blockmeta.com/faucet.php)
- [Bytom gm testnet faucet](http://test.blockmeta.com/faucet_gm.php)